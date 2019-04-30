<?php


namespace app\api\service;


use app\lib\exception\TokenException;
use think\Exception;
use think\facade\Request;

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

    public static function getCurrentTokenVar($key)
    {
        $token = Request::header('token');
        $vars = cache($token);

        if (!$vars) {
            throw new TokenException();
        }

        if (!is_array($vars)) {
            $vars = json_decode($vars, true);
        }
        if (array_key_exists($key, $vars)) {
            return $vars[$key];
        } else {
            throw new Exception('尝试获取的 Token 变量不存在');
        }
    }

    public static function getCurrentUID()
    {
        $uid = self::getCurrentTokenVar('uid');
        return $uid;
    }
}