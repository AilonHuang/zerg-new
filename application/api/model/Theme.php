<?php

namespace app\api\model;

class Theme extends BaseModel
{
    protected $hidden = ['update_time', 'delete_time', 'topic_img_id', 'head_img_id'];

    public function topicImg()
    {
        return $this->belongsTo(Image::class,'topic_img_id', 'id');
    }

    public function headImg()
    {
        return $this->belongsTo(Image::class, 'head_img_id', 'id');
    }
}
