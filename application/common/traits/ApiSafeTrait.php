<?php

namespace app\common\traits;

use app\common\model\ApiModel;
use app\common\model\ElementApiModel;
use app\common\model\UserModel;

trait ApiSafeTrait
{
    use CommonTrait;

    protected $apiSign = true;
    protected $apiAuth = true;
    protected $lifetime = 180;
    protected $appSecret = '@wtf@';
    protected $signRouteWhiteList = [];
    protected $authRouteWhiteList = ['admin/user/permission'];

    public function apiSignCheck()
    {
        $request = request();
        if (!$request->isOptions()) {
            if (!in_array(self::requestRoute(), $this->signRouteWhiteList)) {
                $apiSign = is_null(config('system.api.sign')) ? $this->apiSign : config('system.api.sign');
                $requestParam = array_diff_key($request->param(), $request->route());
                if ($apiSign && !$this->checkSign($request->header(), $request->pathinfo(), $requestParam)) {
                    return false;
                }
            }
        }

        return true;
    }

    public function apiAuthCheck($userId)
    {
        if (!in_array(self::requestRoute(), $this->authRouteWhiteList)) {
            $apiAuth = is_null(config('system.api.auth')) ? $this->apiAuth : config('system.api.auth');
            if ($apiAuth && !$this->checkAuth($userId)) {
                return false;
            }
        }

        return true;
    }

    /**
     * 前后台对称加密验证
     * @param array $header
     * @param string $pathInfo 访问路径
     * @param array $requestParam 请求参数 除路由参数外
     * @return bool
     */
    protected function checkSign(array $header, $pathInfo, array $requestParam)
    {
        if (empty($header['timestamp']) || empty($header['sign'])) {
            return false;
        }

        // 防御DOS攻击
        $lifetime = is_null(config('system.api.lifetime')) ? $this->lifetime : config('system.api.lifetime');
        if ((time() - $header['timestamp']) > $lifetime) {
            return false;
        }

        // 签名验证
        $requestParamStr = '';
        ksort($requestParam);
        foreach ($requestParam as $k => $v) {
            $requestParamStr .= $k . $v;
        }
        $path = '/' . $pathInfo;
        $appSecret = is_null(config('system.api.app_secret')) ? $this->appSecret : config('system.api.app_secret');
        $sign = md5($appSecret . $path . $requestParamStr . $header['timestamp'] . ' ' . $appSecret);
        if ($sign !== $header['sign']) {
            return false;
        }

        return true;
    }

    /**
     * 用户权限验证
     * @param integer $userId
     * @return bool
     */
    protected function checkAuth($userId)
    {
        $userModel = new UserModel();
        $resourceData = $userModel->getResourceByUserId($userId);

        $elementApiModel = new ElementApiModel();
        $apiIds = $elementApiModel->getApiByElementId($resourceData['element_id']);

        $apiModel = new ApiModel();
        $apiData = $apiIds ? $apiModel->getApiByApiIds($apiIds) : [];
        $requestRoute = self::requestRoute();
        $requestMethod = self::requestMethod();
        foreach ($apiData as $row) {
            if ($row['api_route'] == $requestRoute && $row['api_method'] == $requestMethod) {
                return true;
            }
        }

        return false;
    }
}
