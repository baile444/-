<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/11/22
 * Time : 17:09
 * Email: 417780879@qq.com
 */
namespace app\lib\exception;
use think\exception\Handle;
use think\Log;
use think\facade\Request;

class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $errorCode;
    //需要返回客户端当前请求的URL
    // 所有的异常都会经过该方法
    public function render(\Exception $e)
    {
        if ($e instanceof BaseException) {
            //自定义的异常
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        } else {
            //服务器的异常
            if (config('app_debug')) {
                return parent::render($e);
            } else {
                $this->code = 500;
                $this->msg = "服务器内部的异常";
                $this->errorCode = 999;
                $this->recordErrorLog($e);      // 调用记录日志的方法
            }
        }
        $result = [
            'msg' => $this->msg,
            'valid' => $this->errorCode,
        ];
        $logresult = [
            'msg' => $this->msg,
            'valid' => $this->errorCode,
            'request_url' => Request::url()
        ];
        return json($result, $this->code);
    }
    public function recordErrorLog(\Exception $e) {
        // 日志初始化
        Log::init([
            'type' => 'File',
//            'path' => LOG_PATH,
            'level' => ['error']
        ]);
        Log::record($e->getMessage(), 'error');
    }
}