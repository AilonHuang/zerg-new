<?php


namespace app\api\controller\v1;


use app\api\validate\IDMustBePostiveInt;

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
    }
}