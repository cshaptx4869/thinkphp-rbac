<?php

namespace app\common\model;

use app\common\traits\AutoTimestampTrait;
use think\Db;
use think\Model;

class UserRoleModel extends Model
{
    use AutoTimestampTrait;

    protected $table = 'user_role';

    public function getUserRoleByUserIds(array $userIds)
    {
        return Db::table($this->table)->alias('ur')
            ->join('role r', 'r.role_id=ur.role_id')
            ->field('ur.user_id,r.role_name')
            ->whereIn('ur.user_id', $userIds)
            ->where('r.role_status', RoleModel::STATUS_ENABLE)
            ->select();
    }

    public function getRoleByUserId($userId)
    {
        return Db::table($this->table)
            ->where('user_id', $userId)
            ->column('role_id');
    }

    public function userRoleStore($userId, array $roleIds)
    {
        $userRoleData = array_map(function ($roleId) use ($userId) {
            $userRole = ['user_id' => $userId, 'role_id' => $roleId];
            $this->autoTimestamp($userRole);

            return $userRole;
        }, $roleIds);

        return Db::table($this->table)->insertAll($userRoleData);
    }

    public function userRoleDestroy($userId, array $roleIds = [])
    {
        $qb = Db::table($this->table)->where('user_id', $userId);
        if ($roleIds) {
            $qb->whereIn('role_id', $roleIds);
        }

        return $qb->delete() > 0;
    }

    public function userRoleUpdate($userId, array $roleIds)
    {
        $originRoleData = $this->getRoleByUserId($userId);
        $grantRoleData = array_diff($roleIds, $originRoleData);
        $revokeRoleData = array_diff($originRoleData, $roleIds);
        $grantRoleData && $this->userRoleStore($userId, $grantRoleData);
        $revokeRoleData && $this->userRoleDestroy($userId, $revokeRoleData);
    }
}
