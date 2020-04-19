<?php


namespace app\common\traits;


trait CommonTrait
{
    // 获得根目录
    public static function rootPath()
    {
        return str_replace('\\', '/', env('root_path'));
    }

    public static function requestMethod()
    {
        return strtolower(request()->method());
    }

    // 获取请求 模块/控制器/方法
    public static function requestRoute()
    {
        $route = request()->module() . '/' . request()->controller() . '/' . request()->action();

        return strtolower($route);
    }

    public static function controllerClassName()
    {
        $controller = config('app.class_suffix') || config('app.controller_suffix') ?
            request()->controller() . 'Controller' :
            request()->controller();

        return sprintf("\\%s\\%s\\controller\\%s", app('app')->getNamespace(), request()->module(), $controller);
    }
}