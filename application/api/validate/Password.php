<?php
/**
 * author: liukai305
 * since: 2021-01-23 下午 15:41
 */

namespace app\api\validate;


class Password extends BaseValidate
{
    protected $rule = [
        'old_password' => 'require|isPositiveInteger|length:6',
        'new_password' => 'require|isPositiveInteger|length:6'
    ];

    protected $message = [
        'old_password' => '密码必须是6位数的正整数',
        'new_password' => '密码必须是6位数的正整数'
    ];
}