<?php
/**
 * author: liukai305
 * since: 2021-01-18 下午 16:33
 */

namespace app\api\validate;

use think\Validate;
use think\Request;
use app\lib\exception\ParameterException;

class BaseValidate extends Validate
{
    /**
     * 参数验证
     */
    public function goCheck(){
        // 获取参数
        // 进行验证
        $request = Request::instance();
        $params = $request->param();

        $result = $this->batch()->check($params);
        if(!$result) {
            $e = new ParameterException(['msg' => $this->error]);
            throw $e;
        } else {
            return true;
        }
    }

    /**
     * 参数不能为空
     */
    public function isNotEmpty($value, $rule = '', $data = '', $field = ''){
        if(empty($value)){
            return false;
        }else{
            return true;
        }
    }

    /**
     * 参数必须是正整数
     */
    protected function isPositiveInteger($value, $rule = '', $data = '', $field = ''){
        if(is_numeric($value) && is_int($value + 0) && ($value+0)>0){
            return true;
        } else {
            return false;
        }
    }

    /**
     * 手机号码验证
     */
    public function isMobile($value){
        $rule = '^1[0-9]{10}$^';
        $result = preg_match($rule, $value);
        if($result){
            return true;
        }
        return false;
    }
}