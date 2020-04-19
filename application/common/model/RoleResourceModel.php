<?php

namespace app\common\model;

use app\common\traits\AutoTimestampTrait;
use think\Db;
use think\Model;
use utils\MyToolkit;

class RoleResourceModel extends Model
{
    use AutoTimestampTrait;

    const TYPE_MENU = 'menu';
    const TYPE_ELEMENT = 'element';

    protected $table = 'role_resource';

    public static function typeText()
    {
        return [
            self::TYPE_ELEMENT => '元素',
            self::TYPE_MENU => '菜单'
        ];
    }

    public function authorizePreview($roleId)
    {
        $menuModel = new MenuModel();
        $menuTreeFields = 'menu_id|menu_parent_id|menu_children|menu_level';
        $elementModel = new ElementModel();

        return [
            'menu' => MyToolkit::makeTree($menuModel->menuIndex(), $menuTreeFields),
            'authorized_menu' => $this->getMenuByRoleId($roleId),
            'element' => $elementModel->elements(),
            'authorized_element' => $this->getElementByRoleId($roleId)
        ];
    }

    public function roleResourceStore($roleId, array $menuIds, array $elementIds)
    {
        Db::startTrans();
        try {
            $originMenuData = $this->getMenuByRoleId($roleId);
            $grantMenuData = array_diff($menuIds, $originMenuData);
            $grantMenuData && $this->roleMenuStore($roleId, $grantMenuData);
            $revokeMenuData = array_diff($originMenuData, $menuIds);
            $revokeMenuData && $this->roleMenuDestroy($roleId, $revokeMenuData);

            $originElementData = $this->getElementByRoleId($roleId);
            $grantElementData = array_diff($elementIds, $originElementData);
            $grantElementData && $this->roleElementStore($roleId, $grantElementData);
            $revokeElementData = array_diff($originMenuData, $elementIds);
            $revokeElementData && $this->roleElementDestroy($roleId, $revokeElementData);
            Db::commit();

            return true;
        } catch (\Exception $e) {
            Db::rollback();
            halt($e->getMessage());

            return false;
        }
    }

    public function roleResourceDestroy($roleId)
    {
        return Db::table($this->table)
            ->where('role_id', $roleId)
            ->delete();
    }

    public function roleMenuStore($roleId, array $menuIds)
    {
        $roleMenuData = array_map(function ($menuId) use ($roleId) {
            $roleMenu = ['role_id' => $roleId, 'resource_type' => self::TYPE_MENU, 'resource_id' => $menuId];
            $this->autoTimestamp($roleMenu);

            return $roleMenu;
        }, $menuIds);

        return Db::table($this->table)->insertAll($roleMenuData) > 0;
    }

    public function roleMenuDestroy($roleId, array $menuIds)
    {
        return Db::table($this->table)->where('role_id', $roleId)
                ->where('resource_type', self::TYPE_MENU)
                ->whereIn('resource_id', $menuIds)
                ->delete() > 0;
    }

    public function getMenuByRoleId($roleId)
    {
        return Db::table($this->table)
            ->where('role_id', $roleId)
            ->where('resource_type', self::TYPE_MENU)
            ->column('resource_id');
    }

    public function roleElementStore($roleId, array $elementIds)
    {
        $roleElementData = array_map(function ($elementId) use ($roleId) {
            $roleElement = ['role_id' => $roleId, 'resource_type' => self::TYPE_ELEMENT, 'resource_id' => $elementId];
            $this->autoTimestamp($roleElement);

            return $roleElement;
        }, $elementIds);

        return Db::table($this->table)->insertAll($roleElementData) > 0;
    }

    public function roleElementDestroy($roleId, array $elementIds)
    {
        return Db::table($this->table)->where('role_id', $roleId)
                ->where('resource_type', self::TYPE_ELEMENT)
                ->whereIn('resource_id', $elementIds)
                ->delete() > 0;
    }

    public function getElementByRoleId($roleId)
    {
        return Db::table($this->table)
            ->where('role_id', $roleId)
            ->where('resource_type', self::TYPE_ELEMENT)
            ->column('resource_id');
    }

    public function getResourceByRoleId($roleId)
    {
        $qb = Db::table($this->table);
        is_array($roleId) ? $qb->whereIn('role_id', $roleId) : $qb->where('role_id', $roleId);
        $resourceData = $qb->select();

        $menuIds = $elementIds = [];
        foreach ($resourceData as $row) {
            if ($row['resource_type'] == self::TYPE_MENU) {
                $menuIds[] = $row['resource_id'];
            } else {
                $elementIds[] = $row['resource_id'];
            }
        }

        return [
            'menu_id' => $menuIds,
            'element_id' => $elementIds
        ];
    }
}
