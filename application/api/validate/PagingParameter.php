<?php
/**
 * author: liukai305
 * since: 2021-01-23 下午 14:34
 */

namespace app\api\validate;


class PagingParameter extends BaseValidate
{
    protected $rule = [
        'page' => 'isPositiveInteger',
        'size' => 'isPositiveInteger|between:1,15'
    ];

    protected $message = [
        'page' => '分页参数必须是正整数',
        'size' => '分页参数必须是1-15之间的正整数'
    ];
}