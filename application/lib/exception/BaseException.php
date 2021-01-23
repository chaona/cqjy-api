<?php
/**
 * author: liukai305
 * since: 2021-01-18 下午 14:37
 */

namespace app\lib\exception;


use think\Exception;

/**
 * 异常处理基类
 */
class BaseException extends Exception
{
    /*
    错误码	含义
    0	    OK, 成功

    100X 同用类型
    1000	输入参数错误
    1001	输入的json格式不正确
    1002	找不到资源
    1003	未知错误
    1004	禁止访问
    1005	不正确的开发者key
    1006	服务器内部错误

    200x 图书类型
    2000	续借失败
    2001	下架失败

    300x 期刊类型
    错误码	含义
    3000	该期内容不存在

    400x 读者类型
    4000
     */

    /*
    200	OK	请求成功
    201	CREATED	创建成功
    202	ACCEPTED	更新成功
    204	NO CONTENT	删除成功
    301	MOVED PERMANENTLY	永久重定向
    400	BAD REQUEST	请求包含不支持的参数
    401	UNAUTHORIZED	未授权
    403	FORBIDDEN	被禁止访问
    404	NOT FOUND	请求的资源不存在
    413	REQUIRED LENGTH TOO LARGE	上传的File体积太大
    500	INTERNAL SERVER ERROR	内部错误
     */

    // HTTP code
    public $code = 400;
    // error message 具体的错误信息
    public $msg = '参数错误';
    // 自定义错误码
    public $errorCode = 1000;

    public function __construct($params = []) {
        if(!is_array($params)){
            return ;
        }

        if(array_key_exists('code', $params)) {
            $this->code = $params['code'];
        }

        if(array_key_exists('msg', $params)) {
            $this->msg = $params['msg'];
        }

        if(array_key_exists('errorCode', $params)) {
            $this->errorCode = $params['errorCode'];
        }
    }
}