<?php
/**
 * author: liukai305
 * since: 2021-01-19 下午 16:18
 */

namespace app\api\controller\v1;

use app\api\model\Reader as ReaderModel;
use app\api\validate\Password;
use app\api\validate\ReaderLogin;
use app\api\validate\IDParameter;
use app\api\validate\ReaderProfile;
use app\lib\exception\MissException;
use app\lib\enum\ReaderStatusEnum;
use app\lib\exception\SuccessMessage;

class Reader
{
    /**
     * 绑定读者证
     * @url /reader/card
     * @http POST
     */
    public function bindCard($account, $secret){
        (new ReaderLogin())->goCheck();

        $reader = ReaderModel::check($account, $secret);
        if(!$reader){
            throw new MissException([
                'code' => 401,
                'msg' => '账号或密码错误',
                'errorCode' => 1004
            ]);
        }

//        if($reader['status'] != ReaderStatusEnum::NORMAL) {
//            throw new MissException([
//                'code' => 401,
//                'msg' => '读者证号已被暂停使用，请联系管理员',
//                'errorCode' => 1004
//            ]);
//        }

        return $reader;
    }

    /**
     * 根据id获取读者信息
     * @url /reader/detail/:id
     * @http GET
     */
    public function getReaderByID($id){
        (new IDParameter())->goCheck();

        $reader = ReaderModel::getReaderByID($id);
        if(!$reader){
            throw new MissException([
                'code' => 401,
                'msg' => '读者账号不存在',
                'errorCode' => 1004
            ]);
        }

        return $reader;
    }

    /**
     * 修改密码
     * @url /reader/password
     * @http PUT
     */
    public function updatePassword($id, $old_password, $new_password){
        (new IDParameter())->goCheck();
        (new Password())->goCheck();

        $success = ReaderModel::updatePassword($id, $old_password, $new_password);
        if($success){
            return new SuccessMessage();
        }
    }

    /**
     * 修改个人信息
     * @url /reader/profile
     * @http PUT
     */
    public function updateProfile($id, $cell_phone, $address){
        (new IDParameter())->goCheck();
        (new ReaderProfile())->goCheck();

        $success = ReaderModel::updateProfile($id, $cell_phone, $address);
        if($success){
            return new SuccessMessage();
        }
    }


}