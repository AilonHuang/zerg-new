<?php

namespace app\api\controller\v1;

use app\api\model\Banner as BannerModel;
use app\api\validate\IDMustBePostiveInt;
use app\lib\exception\BannerMissException;

class Banner
{
    /**
     * 获取指定 id 的 banner 信息
     * @url /banner/:id
     * @http GET
     * @param $id int banner 的 id
     */
    public function getBanner($id)
    {
        (new IDMustBePostiveInt())->goCheck();
        $banner = BannerModel::getBannerByID($id);
        if ($banner->isEmpty()) {
            throw new BannerMissException();
        }

        return $banner;
    }
}