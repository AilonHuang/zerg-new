<?php


namespace app\lib\exception;


class ThemException extends BaseException
{
    public $code = 404;
    public $msg = '指定的主题不存在，请检查主题 ID';
    public $errorCode = 30000;

}