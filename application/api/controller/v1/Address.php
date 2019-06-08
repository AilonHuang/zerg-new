<?php

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\model\User as UserModel;
use app\api\model\UserAddress;
use app\api\service\Token as TokenService;
use app\api\validate\AddressNew;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;

class Address extends BaseController
{
    protected $beforeActionList = [
        'checkPrimaryScope' => ['only' => 'createOrUpdateAddress,getUserAddress'],
    ];

    public function getUserAddress()
    {
        $uid = TokenService::getCurrentUID();
        $userAddress = UserAddress::where('user_id', '=', $uid)
            ->find();

        if (!$userAddress) {
            throw new UserException([
                'msg' => '用户地址不存在',
                'errorCode' => 60001,
            ]);
        }

        return $userAddress;
    }

    public function createOrUpdateAddress()
    {
        $validate = new AddressNew();
        $validate->goCheck();
        // 根据 token 获取 uid
        // 根据 uid 获取用户数据，判断用户是否存在
        // 获取提交的地址信息
        // 判断是添加还是更新

        $uid = TokenService::getCurrentUID();
        $user = UserModel::get($uid);
        if (!$user) {
            throw new UserException();
        }

        $dataArray = $validate->getDataByRule(input('post.'));
        $userAddress = $user->address;

        if (!$userAddress) {
            $user->address()->save($dataArray);
        } else {
            $user->address->save($dataArray);
        }

        return json(new SuccessMessage(), 201);
    }
}
