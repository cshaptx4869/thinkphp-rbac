<?php

namespace app\admin\validate\role;

use think\Validate;

class RoleStoreValidate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
	    'role_id' => ['require', 'integer'],
	    'role_name' => ['require', 'length:1,30'],
        'role_desc' => ['max:255'],
        'role_status' => ['in:0,1']
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [];

    protected $scene = [
        'store' => ['role_name', 'role_desc', 'role_status'],
        'update' => ['role_id', 'role_name', 'role_desc', 'role_status'],
        'status' => ['role_id', 'role_status']
    ];
}
