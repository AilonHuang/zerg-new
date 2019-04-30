<?php

namespace app\api\model;

class User extends BaseModel
{
    public function address()
    {
        return $this->hasOne(UserAddress::class, 'user_id', 'id');
    }
    public static function getByOpenID($openid)
    {
        $user = self::where('openid', '=', $openid)
            ->find();
        return $user;
    }
}
