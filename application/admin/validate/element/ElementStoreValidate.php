<?php

namespace app\admin\validate\element;

use think\Validate;
use app\common\traits\MyValidateRuleTrait;

class ElementStoreValidate extends Validate
{
    use MyValidateRuleTrait;

    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
	    'element_id' => ['require', 'integer'],
        'element_name' => ['require', 'max:30'],
        'element_type' => ['require', 'in:page,block'],
        'element_code' => ['require', 'max:50'],
        'element_desc' => ['max:255'],
        'element_sort_order' => ['integer'],
        'api_ids' => ['jsonArr', 'hasApis']
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [];

    protected $scene = [
        'store' => ['element_name', 'element_type', 'element_code', 'element_desc', 'element_sort_order', 'api_ids'],
        'update' => ['element_id', 'element_name', 'element_type', 'element_code', 'element_desc', 'element_sort_order', 'api_ids']
    ];
}
