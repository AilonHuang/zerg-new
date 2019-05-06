<?php

namespace app\api\controller\v1;

use app\api\controller\BaseController;

class Order extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only'=>'placeOrder'],
    ];

    public function placeOrder()
    {

    }
}
