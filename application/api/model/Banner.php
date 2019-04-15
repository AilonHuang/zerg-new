<?php

namespace app\api\model;

class Banner extends BaseModel
{
    protected $hidden = ['update_time', 'delete_time'];
    public function items()
    {
        return $this->hasMany(BannerItem::class, 'banner_id', 'id');
    }
    
    public static function getBannerByID($id)
    {
        $banner = self::with('items.img')->get($id);
        return $banner;
    }
}
