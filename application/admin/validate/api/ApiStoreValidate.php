<?php

namespace app\admin\validate\api;

use think\Validate;

class ApiStoreValidate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
	    'api_id' => ['require'],
        'api_name' => ['require', 'length:1,30'],
        'api_route' => ['require', 'length:1,50'],
        'api_method' => ['require', 'in:get,post,put,delete'],
        'api_desc' => ['length:1,255'],
        'api_sort_order' => ['integer']
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [];

    protected $scene = [
        'store' => ['api_name', 'api_route', 'api_method', 'api_desc', 'api_sort_order'],
        'update' => ['api_id', 'api_name', 'api_route', 'api_method', 'api_desc', 'api_sort_order']
    ];
}
