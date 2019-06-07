<?php

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\service\Order as OrderService;
use app\api\service\Token as TokenService;
use app\api\validate\OrderPlace;
use app\api\validate\PagingParameter;
use app\api\model\Order as OrderModel;

class Order extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeOrder'],
        'checkPrimaryScope' => ['only' => 'getSummaryByUser'],
    ];

    public function getSummaryByUser($page = 1, $size = 15)
    {
        (new  PagingParameter())->goCheck();
        $uid = TokenService::getCurrentUID();
        $pagingOrders = OrderModel::getSummaryByUser($uid, $page, $size);
        if ($pagingOrders->isEmpty()) {
            return [
                'data' => [],
                'current_page' => $pagingOrders->getCurrentPage(),
            ];
        }

        $data = $pagingOrders->hidden(['snap_items', 'snap_address', 'prepay_id'])
            ->toArray();
        return [
            'data' => $data,
                'current_page' => $pagingOrders->getCurrentPage(),
            ];

    }

    public function placeOrder()
    {
        (new OrderPlace())->goCheck();
        $products = input('post.products/a');
        $uid = TokenService::getCurrentUID();

        $order = new OrderService();
        $status = $order->place($uid, $products);
        return $status;
    }
}
