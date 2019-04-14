<?php

namespace app\api\validate;

use app\lib\exception\ParameterException;
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
            $exception = new ParameterException();
            $exception->msg = $this->error;
            throw $exception;
        } else {
            return true;
        }
    }
}
