<?php

namespace app\admin\validate\login;

use app\common\facade\SmsSenderFacade;
use think\Validate;

class CodeSignInValidate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'    =>    ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'username' => ['require', 'mobile'],
        'password' => ['require', 'length:6', 'number', 'smsCode'],
        'type' => ['require', 'eq:1']
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'    =>    '错误信息'
     *
     * @var array
     */
    protected $message = [
        'username.mobile' => '手机号格式不正确'
    ];

    protected function smsCode($value, $rule, $data = [], $field, $desc)
    {
        return SmsSenderFacade::isEffective($data['username'], $value) ?: '验证码不正确';
    }
}
