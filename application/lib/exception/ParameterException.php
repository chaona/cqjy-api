<?php
/**
 * author: liukai305
 * since: 2021-01-18 下午 16:37
 */

namespace app\lib\exception;


class ParameterException extends BaseException
{
    public $code = 400;
    public $msg = '参数错误';
    public $errorCode = 1000;
}