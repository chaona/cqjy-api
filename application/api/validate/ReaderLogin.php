<?php
/**
 * author: liukai305
 * since: 2021-01-23 下午 14:42
 */

namespace app\api\validate;


class ReaderLogin extends BaseValidate
{
    protected $rule = [
        'account' => 'require|isNotEmpty',
        'secret' => 'require|isPositiveInteger|length:6'
    ];

    protected $message = [
        'secret' => '密码必须是6位数的正整数'
    ];
}