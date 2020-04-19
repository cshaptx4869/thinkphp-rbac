<?php

namespace app\http\middleware;

use app\common\facade\TokenFacade;
use app\common\traits\ApiSafeTrait;
use think\Request;
use utils\MyToolkit;

class TokenCheckerMiddleware
{
    use ApiSafeTrait;

    public function handle(Request $request, \Closure $next)
    {
        $data = TokenFacade::decode($request->header('Authorization'));
        if ($data === false) {
            exit(json_encode(MyToolkit::login('', TokenFacade::getError())));
        }

        $data = (array)$data;
        $userId = MyToolkit::deHashid($data['data'])[0] ?: 0;//添加参数
        $request->userId = $userId;

        if (!$this->apiAuthCheck($userId)) {
            exit(json_encode(MyToolkit::auth()));
        }

        return $next($request);
    }
}
