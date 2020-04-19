<?php

namespace app\http\behavior;

use app\common\traits\ApiSafeTrait;
use utils\MyToolkit;

class ApiSignCheckerBehavior
{
    use ApiSafeTrait;

    // 行为绑定app_begin钩子后 调用的方法名就是钩子名称的驼峰命名
    public function appBegin()
    {
        if (!$this->apiSignCheck()) {
            exit(json_encode(MyToolkit::error('', 'API安全验证非法')));
        }
    }
}
