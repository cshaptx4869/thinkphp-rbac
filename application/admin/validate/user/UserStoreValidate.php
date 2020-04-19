<?php

namespace app\admin\validate\user;

use app\common\model\RoleModel;
use app\common\traits\MyValidateRuleTrait;
use think\Validate;

class UserStoreValidate extends Validate
{
    use MyValidateRuleTrait;

    /**
     * 定义验证规则
     * 格式：'字段名'    =>    ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        "user_id" => ['require'],
        'user_name' => ['require', 'length:3,30', 'unique:user'],
        'user_password' => ['require'],
        'user_mobile' => ['mobile', 'unique:user'],
        'user_email' => ['email'],
        'user_status' => ['require', 'in:0,1'],
        'role_ids' => ['require', 'jsonArr', 'hasRoles'],
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'    =>    '错误信息'
     *
     * @var array
     */
    protected $message = [
        'user_name.require' => '用户名必填',
        'user_name.string' => '用户名必须在6~30个字符之间',
        'user_name.unique' => '用户名已存在',
        'user_password.require' => '密码必填',
        'user_mobile.mobile' => '手机号非法',
        'user_mobile.unique' => '手机号已存在',
        'user_email.email' => '邮箱非法',
        'user_status.in' => '用户状态非法',
        'role_ids.require' => '角色必填',
    ];

    /**
     * 验证场景
     * @var array
     */
    protected $scene = [
        'store' => ['user_name', 'user_password', 'user_mobile', 'user_email', 'user_status', 'role_ids'],
        'update' => ['user_id', 'user_name', 'user_mobile', 'user_email', 'user_status', 'role_ids'],
        'status' => ['user_id', 'user_status']
    ];
}
