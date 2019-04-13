<?php

namespace app\lib\exception;

use think\exception\Handle;

class ExceptionHandler extends Handle
{
    private $cote;
    private $msg;
    private $errorCode;
    // 需要返回客户端当前请求的 URL 路径


    public function render(\Exception $exception)
    {
        if ($exception instanceof BaseException) {
            // 如果是自定义的异常
            $this->cote = $exception->coed;
            $this->msg = $exception->msg;
            $this->errorCode = $exception->errorCode;
        } else {
            $this->cote = 500;
            $this->msg= '服务器错误，不想告诉你';
            $this->errorCode = 999;
        }

        $result = [
            'msg' => $this->msg,
            'error_code' => $this->errorCode,
            'request_url' => request()->url()
        ];

        return json($result, $this->cote);
    }
}