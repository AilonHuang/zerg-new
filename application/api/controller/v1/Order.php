<?php

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\service\Order as OrderService;
use app\api\service\Token as TokenService;
use app\api\validate\IDMustBePostiveInt;
use app\api\validate\OrderPlace;
use app\api\validate\PagingParameter;
use app\api\model\Order as OrderModel;
use app\lib\exception\OrderException;
use app\lib\exception\SuccessMessage;

class Order extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeOrder'],
        'checkPrimaryScope' => ['only' => 'getDetail, getSummaryByUser'],
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
            'data' => $data['data'],
            'current_page' => $pagingOrders->getCurrentPage(),
        ];

    }

    /**
     * 获取全部订单简要信息（分页）
     * @param int $page
     * @param int $size
     * @return array
     * @throws \app\lib\exception\ParameterException
     */
    public function getSummary($page=1, $size = 20){
        (new PagingParameter())->goCheck();
//        $uid = Token::getCurrentUid();
        $pagingOrders = OrderModel::getSummaryByPage($page, $size);
        if ($pagingOrders->isEmpty())
        {
            return [
                'current_page' => $pagingOrders->currentPage(),
                'data' => []
            ];
        }
        $data = $pagingOrders->hidden(['snap_items', 'snap_address'])
            ->toArray();
        return [
            'current_page' => $pagingOrders->currentPage(),
            'data' => $data['data']
        ];
    }

    public function getDetail($id)
    {
        (new IDMustBePostiveInt())->goCheck();
        $orderDetail = OrderModel::get($id);
        if (!$orderDetail) {
            throw new OrderException();
        }
        return $orderDetail->hidden(['prepay_id']);
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

    public function delivery($id){
        (new IDMustBePostiveInt())->goCheck();
        $order = new OrderService();
        $success = $order->delivery($id);
        if($success){
            return new SuccessMessage();
        }
    }
}
