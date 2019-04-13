<?php

namespace app\api\validate;

use think\Exception;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck()
    {
        // 获取 http 传入的参数
        // 对参数进行校验
        $params = request()->param();

        $result = $this->check($params);

        if (!$result) {
            $error = $this->getError();
            throw new Exception($error);
        } else {
            return true;
        }
    }
}
