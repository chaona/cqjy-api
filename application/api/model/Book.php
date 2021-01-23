<?php
/**
 * author: liukai305
 * since: 2021-01-18 下午 14:07
 */

namespace app\api\model;


use app\lib\enum\BookStatusEnum;
use app\lib\enum\BookTypeEnum;

class Book extends BaseModel
{
    // 设置完整的数据表（包含前缀）
    protected $table = 'library_book';

    /**
     * 最近上传的图书 分页
     * 需要使用group mysql需要支持：my.cnf or my.ini
     * sql_mode=STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION
     */
    public static function getRecent($page=1, $size=5){
        $list = self::where('status', '>', BookStatusEnum::DELETE)
            ->where('type', '=', BookTypeEnum::BOOK)
            ->group('isbsn')
            ->order('create_time desc')
            ->paginate($size, true, ['page'=>$page]);
        return $list;
    }

    /**
     * 获取图书详情
     */
    public static function getDetail($id) {
        $info = self::where('status', '>', BookStatusEnum::DELETE)
//            ->where('book_num', '=', $book_num)
            ->find($id);
        return $info;
    }

    /**
     * 通过书名搜索图书
     */
    public static function searchBooksByName($book_name, $page=1, $size=5) {
        $list = self::where('status', '>', BookStatusEnum::DELETE)
            ->where('book_name', 'like', '%'.$book_name.'%')
            ->order('create_time desc')
            ->paginate($size, false, ['query'=>request()->param()]);
        return $list;
    }

    /**
     * 获取图书总数量
     */
    public static function getAll(){
        $count = self::where('status', '>', BookStatusEnum::DELETE)
            ->count();
        return $count;
    }

    /**
     * 图书借阅排行榜
     */
    public static function getTop(){
        $count = config('setting.borrow_top_count');
        $list = self::where('status', '>', BookStatusEnum::DELETE)
            ->where('type', '=', BookTypeEnum::BOOK)
//            ->group('isbsn')
            ->order('borrow_total desc')
            ->limit($count)
            ->select();
        return $list;
    }
}