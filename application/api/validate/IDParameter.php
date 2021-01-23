<?php
/**
 * author: liukai305
 * since: 2021-01-23 下午 14:55
 */

namespace app\api\validate;


class IDParameter extends BaseValidate
{
    protected $rule = [
        // 验证某个字段的值是否为字母和数字，下划线_及破折号-
        'id' => '^SC-\d+-\d+$'
    ];

    protected $message = [
        'id' => 'id参数不合法'
    ];
}