<?php

namespace app\api\model;

use think\Model;

class BaseModel extends Model
{
    protected function prefixImgUrl($value, $data)
    {
        if (1 == $data['from']) {
            return config('setting.img_prefix') . $value;
        }
        return $value;
    }
}
