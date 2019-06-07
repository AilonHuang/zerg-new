<?php


namespace app\api\service;

use app\api\model\Order as OrderModel;
use app\api\model\Product;
use app\api\service\Order as OrderService;
use app\lib\enum\OrderStatusEnum;
use think\Exception;
use think\facade\Env;
use think\facade\Log;

$extend = Env::get('root_path') . 'extend';
require_once $extend . DIRECTORY_SEPARATOR . 'WxPay' . DIRECTORY_SEPARATOR . 'WxPay.Api.php';

class WxNotify extends \WxPayNotify
{
    public function NotifyProcess($data, &$msg)
    {
        if ($data['result_code'] == 'SUCCESS') {
            $orderNo = $data['out_trade_no'];

            try {
                $order = OrderModel::where('order_no', '=', $orderNo)
                    ->find();
                if ($order->status == 1) {
                    $service = new OrderService;
                   $stockStatus =  $service->checkOrderStock($order->id);
                   if ($stockStatus['pass']) {
                       $this->updateOrderStatus($order->id, true);
                       $this->reduceStock($stockStatus);
                   } else {
                       $this->updateOrderStatus($order->id, false);
                   }
                }
                return true;
            } catch (Exception $exception) {
                Log::error($exception);
                return false;
            }
        } else {
            return true;
        }
    }

    private function updateOrderStatus($orderID, $success)
    {
        $status = $success ? OrderStatusEnum::PAID : OrderStatusEnum::PAID_BUT_OUT_OF;
        OrderModel::where('id', '=', $orderID)
            ->update(['status' => $status]);
    }

    private function reduceStock($stockStatus)
    {
        foreach ($stockStatus['pStatusArray'] as $singlePStatus) {
            Product::where('id', '=', $singlePStatus)
                ->setDec('stock', $singlePStatus['count']);
        }
    }
}