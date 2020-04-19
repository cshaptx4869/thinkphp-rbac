<?php

namespace app\admin\controller;

use app\admin\validate\element\ElementIdValidate;
use app\admin\validate\element\ElementIndexValidate;
use app\admin\validate\element\ElementStoreValidate;
use app\common\controller\BackendController;
use app\common\model\ElementModel;
use Fairy\Annotation\RequestParam;
use Fairy\Annotation\Validator;
use think\Request;
use utils\MyToolkit;

class ElementController extends BackendController
{
    /**
     * 元素列表
     * @Validator(class=ElementIndexValidate::class)
     * @RequestParam(fields={"element_name":"","page","limit"},method="post")
     */
    public function index(Request $request)
    {
        $requestParam = $request->requestParam;
        $elementModel = new ElementModel();

        return MyToolkit::success($elementModel->elementIndex($requestParam));
    }

    /**
     * 元素预加载
     * @return array
     */
    public function preview()
    {
        $elementModel = new ElementModel();

        return MyToolkit::success($elementModel->elementPreview());
    }

    /**
     * 新增元素
     * @Validator(class=ElementStoreValidate::class,scene="store")
     * @RequestParam(
     *     fields={"element_name","element_type","element_code","element_desc":"","element_sort_order":0,"api_ids":"[]"},
     *     json={"api_ids"},
     *     method="post"
     * )
     */
    public function store(Request $request)
    {
        $requestParam = $request->requestParam;
        $elementModel = new ElementModel();

        return MyToolkit::success($elementModel->elementStore($requestParam));
    }

    /**
     * 元素详情
     * @Validator(class=ElementIdValidate::class)
     */
    public function show(Request $request)
    {
        $elementId = $request->post('element_id');
        $elementModel = new ElementModel();

        return MyToolkit::success($elementModel->elementShow($elementId));
    }

    /**
     * 更新元素
     * @Validator(class=ElementStoreValidate::class,scene="update")
     * @RequestParam(
     *     fields={"element_id","element_name","element_type","element_code","element_desc":"","element_sort_order":0,"api_ids":"[]"},
     *     json={"api_ids"},
     *     method="post"
     * )
     */
    public function update(Request $request)
    {
        $requestParam = $request->requestParam;
        $elementId = $requestParam['element_id'];
        unset($requestParam['element_id']);
        $elementModel = new ElementModel();

        return MyToolkit::success($elementModel->elementUpdate($elementId, $requestParam));
    }

    /**
     * 删除元素
     * @Validator(class=ElementIdValidate::class)
     */
    public function destroy(Request $request)
    {
        $elementId = $request->post('element_id');
        $elementModel = new ElementModel();

        return MyToolkit::success($elementModel->elementDestroy($elementId));
    }
}
