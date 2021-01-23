<?php
/**
 * author: liukai305
 * since: 2021-01-23 下午 14:38
 */

namespace app\api\validate;


class ReaderProfile extends BaseValidate
{
    protected $rule = [
        'cell_phone' => 'require|isMobile',
        'address' => 'require|isNotEmpty'
    ];

    protected $message = [
        'cell_phone' => '手机号码格式不正确',
        'address' => '地址不能为空'
    ];
}