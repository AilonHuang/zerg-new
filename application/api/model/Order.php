<?php

namespace app\api\model;

class Order extends BaseModel
{
    protected $hidden = ['user_id', 'delete_time', 'update_time'];

    public $autoWriteTimestamp = true;

    public static function getSummaryByUser($uid, $page = 1, $size = 15)
    {
        $pagingData = self::where('user_id', '=', $uid)
            ->order('create_time', 'desc')
            ->paginate($size, true, ['page' => $page]);

        return $pagingData;
    }
}
