<?php
/**
 * author: liukai305
 * since: 2021-01-18 下午 17:06
 */

namespace app\api\controller\v1;

use app\api\model\Borrow as BorrowModel;
use app\api\validate\IDParameter;
use app\api\validate\PagingParameter;
use app\lib\exception\MissException;
use app\lib\exception\SuccessMessage;

class Borrow
{
    /**
     * 根据用户ID获取借阅清单
     * @url /borrow/all/list/:id
     * @http GET
     */
    public function getBorrowListByID($id, $page=1, $size=5){
        (new IDParameter())->goCheck();
        (new PagingParameter())->goCheck();

        $list = BorrowModel::getMyBorrowListByID($id, $page, $size);
        if($list->isEmpty()){
            return [
                'current_page' => $list->currentPage(),
                'data' => []
            ];
        }
        $data = $list->hidden(['field1','field2','field3'])
            ->toArray();
        return [
            'current_page' => $list->currentPage(),
            'data' => $data
        ];
    }

    /**
     * 根据用户ID获取已经过期图书
     * @url /borrow/expire/list/:id
     * @http GET
     */
    public function getBorrowExpireListByID($id){
        (new IDParameter())->goCheck();

        $list = BorrowModel::getBorrowExpireListByID($id);
        if($list->isEmpty()){
            throw new MissException(['msg'=>'目前没有已过期的图书']);
        }

        return $list;
    }

    /**
     * 根据用户ID获取已经过期图书
     * @url /borrow/soon_expire/list/:id
     * @http GET
     */
    public function getBorrowWillExpireListByID($id){
        (new IDParameter())->goCheck();

        $list = BorrowModel::getBorrowWillExpireListByID($id);
        if($list->isEmpty()){
            throw new MissException(['msg'=>'目前没有将过期的图书']);
        }

        return $list;
    }

    /**
     * 根据用户ID获取在借中的图书
     * @url /borrow/borrowing/list/:id
     * @http GET
     */
    public function getBorrowingExpireListByID($id){
        (new IDParameter())->goCheck();

        $list = BorrowModel::getBorrowingExpireListByID($id);
        if($list->isEmpty()){
            throw new MissException(['msg'=>'目前没有在借中的图书']);
        }

        return $list;
    }

    /**
     * 更加用户ID获取各个清单的数量
     * @url /borrow/
     */
    public function getBorrowCountList($id){
        (new IDParameter())->goCheck();

        $list = [];
        $list['borrowing_count'] = BorrowModel::getBorrowingExpireListCountByID($id);
        $list['will_count'] = BorrowModel::getBorrowWillExpireListCountByID($id);
        $list['expire_count'] = BorrowModel::getBorrowExpireListCountByID($id);
        return $list;
    }

    /**
     * 批量更新 在借中图书
     * @url /renew/status/:id
     * @http PUT
     */
    public function updateBorrowingListRenew($id){
        (new IDParameter())->goCheck();

        $success = BorrowModel::updateBorrowingListRenew($id);
        if(!$success){
            throw new MissException(['msg'=>'已经续借过一次了哦~']);
        }
        return new SuccessMessage();
    }

    /**
     * 批量更新 将过期图书
     * @url /renew/expire/status/:id
     * @http PUT
     */
    public function updateBorrowExpireListRenew($id){
        (new IDParameter())->goCheck();

        $success = BorrowModel::updateBorrowExpireListRenew($id);
        if(!$success){
            throw new MissException(['msg'=>'已经续借过一次了哦~']);
        }
        return new SuccessMessage();
    }
}