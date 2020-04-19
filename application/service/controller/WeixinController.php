<?php

namespace app\service\controller;

use app\service\validate\weixin\MiniOpenidValidate;
use Curl\Curl;
use Fairy\Annotation\Validator;
use think\Controller;
use think\Request;
use utils\MyToolkit;

class WeixinController extends Controller
{
    /**
     * @Validator(class=MiniOpenidValidate::class)
     */
    public function miniOpenid(Request $request)
    {
        $code = $request->post('code');
        $authUrl = strtr(config('system.weixin.mini.authorization_url'), [
            '{APPID}' => config('system.weixin.mini.appid'),
            '{SECRET}' => config('system.weixin.mini.app_sercret'),
            '{JSCODE}' => $code,
        ]);

        $curl = new Curl();
        $data = json_decode($curl->get($authUrl), true);

        return MyToolkit::success($data);
    }
}
