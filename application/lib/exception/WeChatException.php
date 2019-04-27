<?php


namespace app\lib\exception;


class WeChatException extends BaseException
{
    public $code = 404;
    public $msg = '微信服务接口调用失败';
    public $errorCode = 999;

}