<?php


namespace app\lib\exception;
use think\Exception;


class BaseException extends Exception
{
    /**
     * @var int http 状态码
     */
    public $coed = 400;

    /**
     * @var string 错误具体信息
     */
    public $msg = '参数错误';

    /**
     * @var int 自定义的错误码
     */
    public $errorCode = 10000;
}