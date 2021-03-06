<?php

namespace app\admin\validate\login;

use think\Validate;

class AccountSignInValidate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'    =>    ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'username' => ['require', 'max:25'],
        'password' => ['require', 'max:25'],
        'type' => ['require', 'eq:2']
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'    =>    '错误信息'
     *
     * @var array
     */
    protected $message = [];
}
