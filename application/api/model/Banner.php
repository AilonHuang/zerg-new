<?php

namespace app\api\model;

use think\Db;
use think\Model;

class Banner extends Model
{
    public static function getBannerByID($id)
    {
        $result = Db::name('banner_item')
            ->where('banner_id', '=', $id)
            ->select();
        return $result;
    }
}
