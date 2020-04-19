<?php

namespace app\admin\controller;

use app\admin\validate\user\UserIdValidate;
use app\admin\validate\user\UserIndexValidate;
use app\admin\validate\user\UserStoreValidate;
use app\common\controller\BackendController;
use app\common\model\UserModel;
use Fairy\Annotation\RequestParam;
use Fairy\Annotation\Validator;
use think\Request;
use utils\MyToolkit;

class UserController extends BackendController
{
    /**
     * 用户列表
     * @Validator(class=UserIndexValidate::class)
     * @RequestParam(fields={"user_name":"","page","limit"},method="post")
     */
    public function index(Request $request)
    {
        $requestParam = $request->requestParam;
        $userModel = new UserModel();

        return MyToolkit::success($userModel->userIndex($requestParam));
    }

    /**
     * 用户预加载
     * @return array
     */
    public function preview()
    {
        $userModel = new UserModel();

        return MyToolkit::success($userModel->userPreview());
    }

    /**
     * 新增用户
     * @Validator(class=UserStoreValidate::class,scene="store")
     * @RequestParam(
     *     fields={"user_name","user_password","user_mobile","user_email","user_status","role_ids"},
     *     json={"role_ids"},
     *     method="post"
     * )
     */
    public function store(Request $request)
    {
        $requestParam = $request->requestParam;
        $userModel = new UserModel();

        return MyToolkit::success($userModel->userStore($requestParam));
    }

    /**
     * 用户详情
     * @Validator(class=UserIdValidate::class)
     */
    public function show(Request $request)
    {
        $userId = $request->post('user_id');
        $userModel = new UserModel();

        return MyToolkit::success($userModel->userShow($userId));
    }

    /**
     * 更新用户
     * @Validator(class=UserStoreValidate::class,scene="update")
     * @RequestParam(
     *     fields={"user_id","user_name","user_password","user_mobile","user_email","user_status","role_ids"},
     *     json={"role_ids"},
     *     method="post"
     * )
     */
    public function update(Request $request)
    {
        $requestParam = $request->requestParam;
        $userModel = new UserModel();

        return MyToolkit::success($userModel->userUpdate($requestParam));
    }

    /**
     * 更新用户状态
     * @Validator(class=UserStoreValidate::class,scene="status")
     * @RequestParam(fields={"user_id","user_status"},method="post")
     */
    public function status(Request $request)
    {
        $requestParam = $request->requestParam;
        $userModel = new UserModel();

        return MyToolkit::success($userModel->statusUpdate($requestParam));
    }

    /**
     * 删除用户
     * @Validator(class=UserIdValidate::class)
     */
    public function destroy(Request $request)
    {
        $userId = $request->post('user_id');
        $userModel = new UserModel();

        return MyToolkit::success($userModel->userDestroy($userId));
    }

    /**
     * 用户权限点
     * @return array
     */
    public function permission(Request $request)
    {
        $userModel = new UserModel();

        return MyToolkit::success($userModel->userPermission($request->userId));
    }
}
