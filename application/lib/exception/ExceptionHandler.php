<?php

namespace app\lib\exception;

use think\exception\Handle;
use think\facade\Log;

class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $errorCode;

    // 需要返回客户端当前请求的 URL 路径


    public function render(\Exception $exception)
    {
        if ($exception instanceof BaseException) {
            // 如果是自定义的异常
            $this->code = $exception->code;
            $this->msg = $exception->msg;
            $this->errorCode = $exception->errorCode;
        } else {
            if (config('app.app_debug')) {
                return parent::render($exception);
            } else {
                $this->cote = 500;
                $this->msg = '服务器错误，不想告诉你';
                $this->errorCode = 999;
                $this->recordErrorLog($exception);
            }
        }

        $result = [
            'msg' => $this->msg,
            'error_code' => $this->errorCode,
            'request_url' => request()->url(),
        ];

        return json($result, $this->cote);
    }

    private function recordErrorLog(\Exception $exception)
    {
        Log::init([
            'path' => LOG_PATH,
            'level' => ['error'],
        ]);
        Log::write($exception->getMessage(), 'error');
        Log::save();
    }
}