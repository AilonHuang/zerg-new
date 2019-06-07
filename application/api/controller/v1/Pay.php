<?php

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\service\WxNotify;
use app\api\validate\IDMustBePostiveInt;
use app\api\service\Pay as PayService;
use think\facade\Env;

$extend = Env::get('root_path') . 'extend';
require_once $extend . DIRECTORY_SEPARATOR . 'WxPay' . DIRECTORY_SEPARATOR . 'WxPay.Api.php';

class Pay extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'getPreOrder'],
    ];

    public function getPreOrder($id = '')
    {
        (new IDMustBePostiveInt())->goCheck();

        $pay = new PayService($id);
        return $pay->pay();
    }

    public function receiveNotify()
    {
        $config = new \WxPayConfig();
        $notify = new WxNotify();
        $notify->Handle($config);
    }
}
