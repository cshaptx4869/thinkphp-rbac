<?php

namespace app\admin\validate\user;

use think\Validate;

class UserIndexValidate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
	protected $rule = [
	    'user_name' => ['max:30'],
	    'page' => ['require', 'integer'],
        'limit' => ['require', 'integer']
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [];
}
