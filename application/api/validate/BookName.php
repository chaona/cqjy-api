<?php
/**
 * author: liukai305
 * since: 2021-01-18 下午 16:47
 */

namespace app\api\validate;

class BookName extends BaseValidate
{
    protected $rule = [
        'book_name' => 'require|isNotEmpty'
    ];

    protected $message = [
        'book_name' => '书名不能为空'
    ];
}