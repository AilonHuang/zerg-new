<?php

namespace app\api\model;

use think\Exception;
use think\Model;

class Banner extends Model
{
    public static function getBannerByID($id)
    {
        // TODO 根据 banner id 获取 banner 信息
        try {
            1 / 0;
        } catch (Exception $exception) {
            throw $exception;
        }
        return 'this is banner info';
    }
}
