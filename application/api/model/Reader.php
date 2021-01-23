<?php
/**
 * author: liukai305
 * since: 2021-01-19 下午 16:12
 */

namespace app\api\model;

use app\lib\enum\ReaderStatusEnum;
use app\lib\exception\MissException;

class Reader extends BaseModel
{
    /**
     * Reader模型与ReaderType模型建立关联
     */
    public function readerType(){
        // 一对一关系：表里有外键，用belongTo ， 表里没外键 用 hasOne
        return $this->belongsTo('ReaderType', 'reader_type_id', 'id');
    }

    /**
     * 登录验证
     */
    public static function check($account, $secret){
        $reader = self::where('icid_num', '=', $account)
            ->where('field2', '=', $secret)
            ->find();
        return $reader;
    }

    /**
     * 通过id获取用户信息
     */
    public static function getReaderByID($id){
        $reader = self::with('readerType')
            ->find($id);
        return $reader;
    }

    /**
     * 修改密码
     */
    public static function updatePassword($id, $old_password, $password){
        $reader = self::find($id);
        if(!$reader) {
            throw new MissException([
                'code' => 401,
                'msg' => '读者账号不存在',
                'errorCode' => 1004
            ]);
        }
        if($reader->field2 != $old_password){
            throw new MissException([
                'code' => 401,
                'msg' => '旧密码错误',
                'errorCode' => 1004
            ]);
        }
        $reader->field2 = $password;
        return $reader->save();
    }

    /**
     * 修改个人信息
     */
    public static function updateProfile($id, $cell_phone, $address){
        $reader = self::find($id);
        if(!$reader) {
            throw new MissException([
                'code' => 401,
                'msg' => '读者账号不存在',
                'errorCode' => 1004
            ]);
        }
        $reader->cell_phone = $cell_phone;
        $reader->address = $address;
        return $reader->save();
    }
}