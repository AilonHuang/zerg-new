<?php


namespace app\lib\exception;


class BannerMissException implements BaseException
{
    const code = 404;
    const msg = '请求的 Banner 不存在';
    const errorCode = 4000;

}