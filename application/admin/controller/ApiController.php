<?php

namespace app\admin\controller;

use app\admin\validate\api\ApiIdValidate;
use app\admin\validate\api\ApiIndexValidate;
use app\admin\validate\api\ApiStoreValidate;
use app\common\controller\BackendController;
use app\common\model\ApiModel;
use Fairy\Annotation\RequestParam;
use Fairy\Annotation\Validator;
use think\Request;
use utils\MyToolkit;

class ApiController extends BackendController
{
    /**
     * api列表
     * @Validator(class=ApiIndexValidate::class)
     * @RequestParam(fields={"api_name":"","page","limit"},method="post")
     */
    public function index(Request $request)
    {
        $requestParam = $request->requestParam;
        $apiModel = new ApiModel();

        return MyToolkit::success($apiModel->apiIndex($requestParam));
    }

    /**
     * api预加载
     * @return array
     */
    public function preview()
    {
        return MyToolkit::success(MyToolkit::convertToArray(ApiModel::methodText()));
    }

    /**
     * 新增api
     * @Validator(class=ApiStoreValidate::class,scene="store")
     * @RequestParam(fields={"api_name","api_route","api_method","api_desc","api_sort_order"},method="post")
     */
    public function store(Request $request)
    {
        $requestParam = $request->requestParam;
        $apiModel = new ApiModel();

        return MyToolkit::success($apiModel->apiStore($requestParam));
    }

    /**
     * api详情
     * @Validator(class=ApiIdValidate::class)
     */
    public function show(Request $request)
    {
        $apiId = $request->post('api_id');
        $apiModel = new ApiModel();

        return MyToolkit::success($apiModel->apiShow($apiId));
    }

    /**
     * 更新api
     * @Validator(class=ApiStoreValidate::class,scene="update")
     * @RequestParam(fields={"api_id","api_name","api_route","api_method","api_desc","api_sort_order"},method="post")
     */
    public function update(Request $request)
    {
        $requestParam = $request->requestParam;
        $apiId = $requestParam['api_id'];
        unset($requestParam['api_id']);
        $apiModel = new ApiModel();

        return MyToolkit::success($apiModel->apiUpdate($apiId, $requestParam));
    }

    /**
     * 删除api
     * @Validator(class=ApiIdValidate::class)
     */
    public function destroy(Request $request)
    {
        $apiId = $request->post('api_id');
        $apiModel = new ApiModel();

        return MyToolkit::success($apiModel->apiDestroy($apiId));
    }
}
