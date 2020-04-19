<?php


namespace app\common\traits;


use app\common\facade\SmsSenderFacade;
use app\common\model\ApiModel;
use app\common\model\RoleModel;

trait MyValidateRuleTrait
{
    /**
     * json数组
     * @param mixed $value 待验证的数据
     * @param mixed $rule 验证的规则
     * @param array $data 全部数据（数组）
     * @param string $field 字段名
     * @param string $desc 字段描述
     * @return bool|string
     */
    protected function jsonArr($value, $rule, $data = [], $field, $desc)
    {
        $value = json_decode($value, true);

        return is_array($value) ? true : $field . '格式不正确';
    }

    /**
     * 角色是否存在
     * @param $value
     * @param $rule
     * @param array $data
     * @param $field
     * @param $desc
     * @return bool|string
     */
    protected function hasRole($value, $rule, $data = [], $field, $desc)
    {
        $roleModel = new RoleModel();

        return $roleModel->hasRole($value) ? true : '分配的角色不存在';
    }

    protected function hasRoles($value, $rule, $data = [], $field, $desc)
    {
        $roleModel = new RoleModel();
        $roleIds = json_decode($value, true);
        $bool = true;
        foreach ($roleIds as $roleId) {
            if (!in_array($roleId, $roleModel->roleIds())) {
                $bool = false;
                break;
            }
        }

        return $bool ? true : '分配的角色不存在';
    }

    public function hasApis($value, $rule, $data = [], $field, $desc)
    {
        $apiModel = new ApiModel();
        $apiIds = json_decode($value, true);
        $bool = true;
        foreach ($apiIds as $apiId) {
            if (!in_array($apiId, $apiModel->apiIds())) {
                $bool = false;
                break;
            }
        }

        return $bool ? true : '分配的接口不存在';
    }

    /**
     * 验证码
     * @param $value
     * @param $rule
     * @param array $data
     * @param $field
     * @param $desc
     * @return string
     */
    protected function smsCode($value, $rule, $data = [], $field, $desc)
    {
        $mobileKey = property_exists($this, 'mobileKey') ? $this->mobileKey : 'mobile';

        return SmsSenderFacade::isEffective($data[$mobileKey], $value) ?: '验证码不正确';
    }
}
