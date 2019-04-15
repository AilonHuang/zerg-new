<?php

namespace app\api\validate;

use think\Validate;

class IDCollection extends BaseValidate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
	    'ids' => 'require|checkIDs'
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'ids' => 'ids 参数必须是以逗号分隔的多个正整数'
    ];

    protected function checkIDs($value)
    {
        $values = explode(',', $value);
        if (empty($values)) {
            return false;
        }

        foreach ($values as $id) {
            if (!$this->isPositiveInteger($id)) {
                return false;
            }
        }

        return true;
    }
}
