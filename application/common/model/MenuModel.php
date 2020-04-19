<?php

namespace app\common\model;

use app\common\traits\AutoTimestampTrait;
use think\Db;
use think\db\Query;
use think\Model;

class MenuModel extends Model
{
    use AutoTimestampTrait;

    const STATUS_ENABLE = 0;
    const STATUS_DISABLE = 1;

    protected $table = 'menu';

    public static function statusText()
    {
        return [
            self::STATUS_ENABLE => '启用',
            self::STATUS_DISABLE => '禁用'
        ];
    }

    public function menuIndex(array $params = [])
    {
        $qb = Db::table($this->table)
            ->field('menu_id,menu_parent_id,menu_name,menu_icon,menu_href,menu_sort_order,menu_status,created_at');
        $this->menuIndexCondition($qb, $params);
        $menus = $qb->order(['menu_sort_order', 'menu_id'])->select();

        $data = [];
        foreach ($menus as $menu) {
            $menu['menu_status'] = $menu['menu_status'] == self::STATUS_ENABLE ? true : false;
            $menu['created_at'] = $menu['created_at'] ? date('Y-m-d H:i:s', $menu['created_at']) : '';

            $data[] = $menu;
        }

        return $data;
    }

    public function menuIndexCondition(Query $qb, array $params)
    {
        if (isset($params['menu_name']) && $params['menu_name']) {
            $qb->whereLike('menu_name', '%' . $params['menu_name'] . '%');
        }
    }

    public function getMenuByMenuIds(array $menuIds)
    {
        return Db::table($this->table)
            ->where('menu_status', self::STATUS_ENABLE)
            ->whereIn('menu_id', $menuIds)
            ->field('menu_id,menu_parent_id,menu_name,menu_icon,menu_href,menu_sort_order')
            ->order('menu_sort_order')
            ->select();
    }

    public function menuStore(array $params)
    {
        $this->autoTimestamp($params);

        return Db::table($this->table)->insert($params) > 0;
    }

    public function menuShow($menuId)
    {
        return Db::table($this->table)
            ->where('menu_id', $menuId)
            ->field('menu_id,menu_parent_id,menu_name,menu_icon,menu_href,menu_sort_order,menu_status')
            ->find();
    }

    public function menuUpdate($menuId, array $params)
    {
        $this->updatedAt($params);

        return Db::table($this->table)
                ->where('menu_id', $menuId)
                ->update($params) > 0;
    }

    public function statusUpdate(array $params)
    {
        $menuId = $params['menu_id'];
        unset($params['menu_id']);
        $this->updatedAt($params);

        Db::table($this->table)->where('menu_id', $menuId)->update($params);

        return true;
    }

    public function menuDestroy($menuId)
    {
        return Db::table($this->table)
                ->where('menu_id', $menuId)
                ->delete() > 0;
    }

    public function menus()
    {
        return Db::table($this->table)
            ->where('menu_status', self::STATUS_ENABLE)
            ->field('menu_id,menu_name')
            ->select();
    }
}
