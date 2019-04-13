<?php


namespace app\lib\exception;


interface BaseException
{
    /**
     * @var int http 状态码
     */
    const coed = 400;

    /**
     * @var string 错误具体信息
     */
    const msg = '参数错误';

    /**
     * @var int 自定义的错误码
     */
    const errorCode = 10000;
}