<?php

namespace app\api\service;

use app\api\model\Product;
use app\lib\exception\OrderException;

class Order
{
    // 客户端传过来的 products 参数
    protected $oProducts;

    // 真实的商品信息（包括k库存量）
    protected $products;

    protected $uid;

    public function place($uid, $oProducts)
    {
        $this->oProducts = $oProducts;
        $this->products = $this->getProductsByOrder($oProducts);
        $this->uid = $uid;
    }

    private function getOrderStatus()
    {
        $status = [
            'pass' => true,
            'orderPrice' => 0,
            'pStatusArray' => [],
        ];

        foreach ($this->oProducts as $oProduct) {
            $pStatus = $this->getProductStatus($oProduct['product_id'], $oProduct['count'], $this->products);
            if (!$pStatus['haveStock']) {
                $status['pass'] = false;
            }
            $status['orderPrice'] += $pStatus['totalPrice'];
            array_push($pStatusArray, $pStatus);
        }

        return $status;
    }

    private function getProductStatus($oPID, $oCount, $products)
    {
        $pIndex = -1;

        $pStatus = [
            'id' => '',
            'haveStock' => false,
            'count' => 0,
            'name' => '',
            'totalPrice' => 0,
        ];

        for ($i = 0; $i < count($products); $i++) {
            if ($oPID == $products[$i]['id']) {
                $pIndex = $i;
            }
        }

        if ($pIndex == -1) {
            // 客户端传递的 id 不存在
            throw new OrderException([
                'msg' => 'id 为' . $oPID . '的商品存在，创建订单失败',
            ]);
        } else {
            $product = $products[$pIndex];
            $pStatus['id'] = $product['id'];
            $pStatus['name'] = $product['name'];
            $pStatus['count'] = $oCount;
            $pStatus['totalPrice'] = $product['price'] * $oCount;

            if ($product['stock'] - $oCount >= 0) {
                $pStatus['haveStock'] = true;
            }
        }
    }

    // 根据订单查询真是的商品信息
    private function getProductsByOrder($oProducts)
    {
        $oPIDs = [];
        foreach ($oProducts as $item) {
            array_push($oPIDs, $item['product_id']);
        }

        $products = Product::all($oPIDs)
            ->visiable(['id', 'price', 'stock', 'name', 'main_img_url'])
            ->toArray();

        return $products;
    }
}