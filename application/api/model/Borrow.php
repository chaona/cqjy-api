<?php
/**
 * author: liukai305
 * since: 2021-01-18 下午 17:03
 */

namespace app\api\model;


use app\lib\enum\ReaderStatusEnum;
use app\lib\enum\RenewStatusEnum;

class Borrow extends BaseModel
{
    protected function getBorrowTimeAttr($time)
    {
        // TODO 数据库字段设计优化
        return $time;//返回borrow_time原始数据，不进行时间戳转换。
    }

    protected function getReturnTimeAttr($time)
    {
        // TODO 数据库字段设计优化
        return $time;//返回return_time原始数据，不进行时间戳转换。
    }

    protected function getFactTimeAttr($time)
    {
        // TODO 数据库字段设计优化
        return $time;//返回fact_time原始数据，不进行时间戳转换。
    }

    /**
     * 获取累计借还数量
     */
    public static function getAll(){
        $count = self::count();
        return $count;
    }

    /**
     * 根据用户ID获取借阅清单
     */
    public static function getMyBorrowListByID($id, $page=1, $size=5){
        $list = self::where('reader_id', '=', $id)
//            ->where('fact_time', 'not null')
            ->order('borrow_time desc')
            ->paginate($size, true, ['page'=>$page]);
        return $list;
    }

    /**
     * 根据用户ID获取已经过期的借阅清单
     */
    public static function getBorrowExpireListByID($id){
        $now_time = date('Y-m-d H:i:s',time());
        $list = self::where('reader_id', '=', $id)
            ->where('fact_time', 'null')
            ->where('return_time', '<', $now_time)
            ->order('borrow_time desc')
            ->select();
        return $list;
    }

    /**
     * 根据用户ID获取已经过期的借阅清单 的数量
     */
    public static function getBorrowExpireListCountByID($id){
        $now_time = date('Y-m-d H:i:s',time());
        $count = self::where('reader_id', '=', $id)
            ->where('fact_time', 'null')
            ->where('return_time', '<', $now_time)
            ->count();
        return $count;
    }

    /**
     * 根据用户ID获取将过期的借阅清单
     */
    public static function getBorrowWillExpireListByID($id){
        $now_time = date('Y-m-d H:i:s', time());
        $will_time = date('Y-m-d H:i:s', (time()+config('setting.borrow_expire_day')*24*60*60));
        $list = self::where('reader_id', '=', $id)
            ->where('fact_time', 'null')
            ->whereTime('return_time', 'between', [$now_time, $will_time])
            ->order('borrow_time desc')
            ->select();
        return $list;
    }

    /**
     * 根据用户ID获取将过期的借阅清单 的数量
     */
    public static function getBorrowWillExpireListCountByID($id){
        $now_time = date('Y-m-d H:i:s', time());
        $will_time = date('Y-m-d H:i:s', (time()+config('setting.borrow_expire_day')*24*60*60));
        $count = self::where('reader_id', '=', $id)
            ->where('fact_time', 'null')
            ->whereTime('return_time', 'between', [$now_time, $will_time])
            ->count();
        return $count;
    }

    /**
     * 根据用户id续借图书 将过期
     */
    public static function updateBorrowExpireListRenew($id){
        $now_time = date('Y-m-d H:i:s', time());
        $will_time = date('Y-m-d H:i:s', (time()+config('setting.borrow_expire_day')*24*60*60));
        $list = self::where('reader_id', '=', $id)
            ->where('fact_time', 'null')
            ->where('renew', '=', RenewStatusEnum::YES)
            ->whereTime('return_time', 'between', [$now_time, $will_time])
            ->select();

        // 先判断有没有 可续借的图书数量
        if($list->isEmpty()){
            return false;
        }

        // 再进行续借操作
        $reader = Reader::getReaderByID($id);
        foreach($list as $borrow){
            $return_time_int = strtotime($borrow->return_time);
            $return_time = date('Y-m-d H:i:s', $return_time_int+$reader->reader_type->renew_day*24*3600);
            $borrow->renew = RenewStatusEnum::NO;
            $borrow->return_time = $return_time;
            $borrow->save();
        }
        return true;
    }

    /**
     * 根据用户ID获取在借中的借阅清单
     */
    public static function getBorrowingExpireListByID($id){
        $now_time = date('Y-m-d H:i:s', time());
        $will_time = date('Y-m-d H:i:s', (time()+config('setting.borrow_expire_day')*24*60*60));
        $list = self::where('reader_id', '=', $id)
            ->where('fact_time', 'null')
            ->whereTime('return_time', 'not between', [$now_time, $will_time])
            ->where('return_time', '>', $now_time)
            ->order('borrow_time desc')
            ->select();
        return $list;
    }

    /**
     * 根据用户ID获取在借中的借阅清单 的数量
     */
    public static function getBorrowingExpireListCountByID($id){
        $now_time = date('Y-m-d H:i:s', time());
        $will_time = date('Y-m-d H:i:s', (time()+config('setting.borrow_expire_day')*24*60*60));
        $count = self::where('reader_id', '=', $id)
            ->where('fact_time', 'null')
            ->whereTime('return_time', 'not between', [$now_time, $will_time])
            ->where('return_time', '>', $now_time)
            ->count();
        return $count;
    }

    /**
     * 根据用户id续借图书 在借中
     */
    public static function updateBorrowingListRenew($id){
        $now_time = date('Y-m-d H:i:s', time());
        $will_time = date('Y-m-d H:i:s', (time()+config('setting.borrow_expire_day')*24*60*60));

        $list = self::where('reader_id', '=', $id)
            ->where('fact_time', 'null')
            ->where('renew', '=', RenewStatusEnum::YES)
            ->whereTime('return_time', 'not between', [$now_time, $will_time])
            ->where('return_time', '>', $now_time)
            ->select();

        // 先判断有没有 可续借的图书数量
        if($list->isEmpty()){
            return false;
        }

        // 再进行续借操作
        $reader = Reader::getReaderByID($id);
        foreach($list as $borrow){
            $return_time_int = strtotime($borrow->return_time);
            $return_time = date('Y-m-d H:i:s', $return_time_int+$reader->reader_type->renew_day*24*3600);
            $borrow->renew = RenewStatusEnum::NO;
            $borrow->return_time = $return_time;
            $borrow->save();
        }
        return true;
    }
}