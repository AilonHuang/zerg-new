<?php

namespace app\api\controller\v1;

use app\api\validate\AddressNew;
use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\SuccessMessage;
use app\lib\exception\TokenException;
use app\lib\exception\UserException;
use think\Controller;
use app\api\service\Token as TokenService;
use app\api\model\User as UserModel;

class Address extends Controller
{
    protected $beforeActionList = [
        'checkPrimaryScope' => ['only'=>'createOrUpdateAddress'],
    ];

    protected function checkPrimaryScope()
    {
        $scope =  TokenService::getCurrentTokenVar('scope');
        if (!$scope) {
            throw new TokenException();
        }
        if ($scope >= ScopeEnum::USER) {
            return true;
        }
        throw new ForbiddenException();
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
