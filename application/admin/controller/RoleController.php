<?php

namespace app\admin\controller;

use app\admin\validate\role\RoleAuthorizeValidate;
use app\admin\validate\role\RoleIdValidate;
use app\admin\validate\role\RoleIndexValidate;
use app\admin\validate\role\RoleStoreValidate;
use app\common\controller\BackendController;
use app\common\model\RoleModel;
use app\common\model\RoleResourceModel;
use Fairy\Annotation\RequestParam;
use Fairy\Annotation\Validator;
use think\Request;
use utils\MyToolkit;

class RoleController extends BackendController
{
    /**
     * 角色列表
     * @Validator(class=RoleIndexValidate::class)
     * @RequestParam(fields={"page","limit"},method="post")
     */
    public function index(Request $request)
    {
        $params = $request->requestParam;
        $userModel = new RoleModel($params);

        return MyToolkit::success($userModel->roleIndex($params));
    }

    /**
     * 角色预加载
     * @return array
     */
    public function preview()
    {
        $roleModel = new RoleModel();

        return MyToolkit::success($roleModel->rolePreview());
    }

    /**
     * 新增角色
     * @Validator(class=RoleStoreValidate::class,scene="store")
     * @RequestParam(fields={"role_name","role_desc","role_status"},method="post")
     */
    public function store(Request $request)
    {
        $requestParam = $request->requestParam;
        $roleModel = new RoleModel();

        return MyToolkit::success($roleModel->roleStore($requestParam));
    }

    /**
     * 角色详情
     * @Validator(class=RoleIdValidate::class)
     */
    public function show(Request $request)
    {
        $roleId = $request->post('role_id');
        $roleModel = new RoleModel();

        return MyToolkit::success($roleModel->roleShow($roleId));
    }

    /**
     * 更新角色
     * @Validator(class=RoleStoreValidate::class,scene="update")
     * @RequestParam(fields={"role_id","role_name","role_desc","role_status"})
     */
    public function update(Request $request)
    {
        $requestParam = $request->requestParam;
        $roleId = $requestParam['role_id'];
        unset($requestParam['roleId']);
        $roleModel = new RoleModel();

        return MyToolkit::success($roleModel->roleUpdate($roleId, $requestParam));
    }

    /**
     * 更新角色状态
     * @Validator(class=RoleStoreValidate::class,scene="status")
     * @RequestParam(fields={"role_id","role_status"},method="post")
     */
    public function status(Request $request)
    {
        $requestParam = $request->requestParam;
        $roleModel = new RoleModel();

        return MyToolkit::success($roleModel->statusUpdate($requestParam));
    }

    /**
     * 删除角色
     * @Validator(class=RoleIdValidate::class)
     */
    public function destroy(Request $request)
    {
        $roleId = $request->post('role_id');
        $roleModel = new RoleModel();

        return MyToolkit::success($roleModel->roleDestroy($roleId));
    }

    /**
     * 角色授权预加载
     * @Validator(class=RoleIdValidate::class)
     */
    public function authorizePreview(Request $request) {
        $roleId = $request->post('role_id');
        $roleResourceModel = new RoleResourceModel();

        return MyToolkit::success($roleResourceModel->authorizePreview($roleId));
    }

    /**
     * 角色授权
     * @Validator(class=RoleAuthorizeValidate::class)
     * @RequestParam(fields={"menu_id","element_id","role_id"},json={"menu_id","element_id"})
     */
    public function authorize(Request $request)
    {
        $requestParam = $request->requestParam;
        $roleResourceModel = new RoleResourceModel();

        return MyToolkit::success(
            $roleResourceModel->roleResourceStore($requestParam['role_id'], $requestParam['menu_id'], $requestParam['element_id'])
        );
    }
}
