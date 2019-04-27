<?php


namespace app\api\service;


class Token
{
    public static function generateToken()
    {
        // 32 个随机字符串
        $randChars = getRandChars(32);
        // 加密
        $timestamp = $_SERVER['REQUEST_TIME'];
        $salt = config('secure.token_salt');
        return md5($randChars . $timestamp . $salt);
    }
}