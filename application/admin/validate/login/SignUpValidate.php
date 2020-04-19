<?php

namespace app\admin\validate\login;

use app\common\traits\MyValidateRuleTrait;
use think\Validate;

class SignUpValidate extends Validate
{
    use MyValidateRuleTrait;

    protected $mobileKey = 'user_mobile';

    /**
     * 定义验证规则
     * 格式：'字段名'    =>    ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'user_name' => ['require', 'max:30', 'unique:user'],
        'user_nickname' => ['max:30'],
        'user_password' => ['require', 'max:25'],
        'user_mobile' => ['require', 'mobile', 'unique:user'],
        'code' => ['require', 'smsCode']
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'    =>    '错误信息'
     *
     * @var array
     */
    protected $message = [];
}
