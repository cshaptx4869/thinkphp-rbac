<?php

namespace app\admin\controller;

use app\admin\validate\menu\MenuIdValidate;
use app\admin\validate\menu\MenuStoreValidate;
use app\common\controller\BackendController;
use app\common\model\MenuModel;
use Fairy\Annotation\RequestParam;
use Fairy\Annotation\Validator;
use think\Request;
use utils\MyToolkit;

class MenuController extends BackendController
{
    /**
     * 菜单
     * @RequestParam(fields={"menu_name":""},method="post")
     */
    public function index(Request $request)
    {
        $requestParam = $request->requestParam;
        $menuModel = new MenuModel();
        $menuTreeFields = 'menu_id|menu_parent_id|menu_children|menu_level';

        return MyToolkit::success(MyToolkit::makeTree($menuModel->menuIndex($requestParam), $menuTreeFields));
    }

    /**
     * 菜单预加载
     * @return array
     */
    public function preview()
    {
        return MyToolkit::success(MyToolkit::convertToArray(MenuModel::statusText()));
    }

    /**
     * 新增菜单
     * @Validator(class=MenuStoreValidate::class,scene="store")
     * @RequestParam(
     *     fields={"menu_parent_id","menu_name","menu_icon","menu_href","menu_sort_order","menu_status"},
     *     method="post"
     * )
     */
    public function store(Request $request)
    {
        $requestParam = $request->requestParam;
        $menuModel = new MenuModel();

        return MyToolkit::success($menuModel->menuStore($requestParam));
    }

    /**
     * 菜单详情
     * @Validator(class=MenuIdValidate::class)
     */
    public function show(Request $request)
    {
        $menuId = $request->post('menu_id');
        $menuModel = new MenuModel();

        return MyToolkit::success($menuModel->menuShow($menuId));
    }

    /**
     * 更新菜单
     * @Validator(class=MenuStoreValidate::class,scene="update")
     * @RequestParam(
     *     fields={"menu_id","menu_parent_id","menu_name","menu_icon","menu_href","menu_sort_order","menu_status"},
     *     method="post"
     * )
     */
    public function update(Request $request)
    {
        $requestParam = $request->requestParam;
        $menuId = $requestParam['menu_id'];
        unset($requestParam['menu_id']);
        $menuModel = new MenuModel();

        return MyToolkit::success($menuModel->menuUpdate($menuId, $requestParam));
    }

    /**
     * 更新菜单状态
     * @Validator(class=MenuStoreValidate::class,scene="status")
     * @RequestParam(fields={"menu_id","menu_status"},method="post")
     */
    public function status(Request $request)
    {
        $requestParam = $request->requestParam;
        $menuModel = new MenuModel();

        return MyToolkit::success($menuModel->statusUpdate($requestParam));
    }

    /**
     * 删除菜单
     * @Validator(class=MenuIdValidate::class)
     */
    public function destroy(Request $request)
    {
        $menuId = $request->post('menu_id');
        $menuModel = new MenuModel();

        return MyToolkit::success($menuModel->menuDestroy($menuId));
    }
}
