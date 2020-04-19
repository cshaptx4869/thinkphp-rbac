<?php

namespace app\common\model;

use app\common\traits\AutoTimestampTrait;
use think\Db;
use think\Model;
use utils\MyToolkit;

class RoleModel extends Model
{
    use AutoTimestampTrait;

    const STATUS_ENABLE = 0;
    const STATUS_DISABLE = 1;

    const TYPE_SYSTEM = 'system';
    const TYPE_CUSTOM = 'custom';

    protected $table = 'role';

    public static function statusText()
    {
        return [
            self::STATUS_ENABLE => '启用',
            self::STATUS_DISABLE => '禁用'
        ];
    }

    public static function typeText()
    {
        return [
            self::TYPE_SYSTEM => '内置角色',
            self::TYPE_CUSTOM => '自定义角色'
        ];
    }

    public function roleIndex(array $params)
    {
        $qb = Db::table($this->table);
        if (!$count = $qb->count()) {
            return MyToolkit::paginate([], $params['page'], $params['limit'], 0);
        }
        $roles = $qb->page($params['page'], $params['limit'])->select();
        $data = [];
        foreach($roles as $role) {
            $data[] = [
                'role_id' => $role['role_id'],
                'role_name' => $role['role_name'],
                'role_desc' => $role['role_desc'],
                'role_status' => $role['role_status'] == self::STATUS_ENABLE ? true : false,
                'created_at' => $role['created_at'] ? date('Y-m-d H:i:s', $role['created_at']) : ''
            ];
        }

        return MyToolkit::paginate($data, $params['page'], $params['limit'], $count);
    }

    public function rolePreview()
    {
        $menuModel = new MenuModel();
        $elementModel = new ElementModel();

        return [
            'role_status' => MyToolkit::convertToArray(self::statusText()),
            'resource' => [
                'menu' => $menuModel->menus(),
                'element' => $elementModel->elements()
            ],
        ];
    }

    public function roleStore(array $params)
    {
        $this->autoTimestamp($params);

        return Db::table($this->table)->insert($params) > 0;
    }

    public function roleShow($id)
    {
        return Db::table($this->table)
            ->where('role_id', $id)
            ->field('role_id,role_name,role_desc,role_status')
            ->find();
    }

    public function roleUpdate($roleId, array $params)
    {
        $this->updatedAt($params);

        return Db::table($this->table)
                ->where('role_id', $roleId)
                ->update($params) > 0;
    }

    public function statusUpdate(array $params)
    {
        $userId = $params['role_id'];
        unset($params['role_id']);
        $this->updatedAt($params);

        Db::table($this->table)->where('role_id', $userId)->update($params);

        return true;
    }

    public function roleDestroy($roleId)
    {
        Db::startTrans();
        try {
            Db::table($this->table)
                ->where('role_id', $roleId)
                ->delete();
            $roleResourceModel = new RoleResourceModel();
            $roleResourceModel->roleResourceDestroy($roleId);
            Db::commit();

            return true;
        } catch (\Exception $e) {
            Db::rollback();

            return false;
        }
    }

    public function roles()
    {
        return Db::table($this->table)
            ->where('role_status', self::STATUS_ENABLE)
            ->column('role_name', 'role_id');
    }

    public function roleIds()
    {
        return Db::table($this->table)
            ->where('role_status', self::STATUS_ENABLE)
            ->column('role_id');
    }

    public function hasRole($roleId)
    {
        return Db::table($this->table)
                ->where('role_id', $roleId)
                ->where('role_status', self::STATUS_ENABLE)
                ->count() > 0;
    }
}
