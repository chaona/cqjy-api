<?php
/**
 * author: liukai305
 * since: 2021-01-18 下午 14:46
 */

namespace app\lib\exception;


use think\exception\Handle;
use think\Log;
use think\Request;

/**
 * 自定义异常处理类
 * 可以记录错误日志
 * TODO 邮件发送错误日志
 */
class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $errorCode;
    // 第四个参数，需要返回客户端当前请求的url

    /**
     * @param \Exception $e
     * @return \think\Response
     */
    public function render(\Exception $e){
        if($e instanceof BaseException){
            // 如果是自定义的异常
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        } else {
            // 不是自定义的异常，交由tp原来的异常处理
            if(config('app_debug')){
                return parent::render($e);
            } else {
                $this->code = 500;
                $this->msg = '程序员正在努力修复bug';
                $this->errorCode = 888; // 888未知错误代码
                // 记录错误日志
                $this->recordErrorLog($e);
            }
        }

        $request = Request::instance();
        $result = [
            'msg' => $this->msg,
            'error_code' => $this->errorCode,
            'request_url' => $request->url()
        ];

        return json($result, $this->code);
    }

    /**
     * 记录错误日志
     * @param \Exception $e
     */
    private function recordErrorLog(\Exception $e) {
        Log::init([
            'type' => 'File',
            'path' => LOG_PATH,
            'level' => ['error']
        ]);
        Log::record($e->getMessage(), 'error');
    }
}