<?php

namespace app\admin\validate\role;

use app\common\traits\MyValidateRuleTrait;
use think\Validate;

class RoleAuthorizeValidate extends Validate
{
    use MyValidateRuleTrait;

    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
	protected $rule = [
        'role_id' => ['require', 'hasRole'],
	    'menu_id' => ['require', 'jsonArr'],
        'element_id' => ['require', 'jsonArr'],
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [];
}
