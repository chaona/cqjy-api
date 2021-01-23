<?php
/**
 * author: liukai305
 * since: 2021-01-18 下午 14:45
 */

namespace app\lib\exception;

/**
 * 404时抛出此异常
 */
class MissException extends BaseException
{
    public $code = 404;
    public $msg = '请求的资源不存在';
    public $errorCode = 1002;
}