<?php

namespace app\api\validate;

use app\lib\exception\ParameterException;

class OrderPlace extends BaseValidate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
	protected $rule = [
	    'products' => 'checkProducts'
    ];

	protected $singleRule = [
	    'product_id' => 'required|isPositiveInteger',
	    'count' => 'required|isPositiveInteger'
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [];

    protected function checkProducts($values)
    {
        if (!is_array($values)) {
            throw new ParameterException([
                'msg' => '商品参数不正确'
            ]);
        }

        if (empty($values)) {
            throw new ParameterException([
                'msg' => '商品列表不能为空'
            ]);
        }

        foreach($values as $value) {
            $this->checkProduct($value);
        }

        return true;
    }

    protected function checkProduct($value)
    {
        $validate = new BaseValidate($this->singleRule);
        $result = $validate->check($value);
        if (!$result) {
            throw new ParameterException([
                'msg' => '商品列表参数错误'
            ]);
        }
    }
}