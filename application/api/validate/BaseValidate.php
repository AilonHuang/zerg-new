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

        $result = $this->batch()->check($params);

        if (!$result) {
            throw new ParameterException([
                'msg' => $this->error,
            ]);
        } else {
            return true;
        }
    }

    protected function isPositiveInteger($value, $rule = [], $data = [], $field = [])
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        } else {
            return false;
        }
    }

    protected function isNotEmpty($value, $rule = [], $data = [], $field = [])
    {
        if (empty($value)) {
            return false;
        } else {
            return true;
        }
    }
}
