<?php

namespace app\admin\controller;

use app\admin\validate\login\AccountSignInValidate;
use app\admin\validate\login\BindValidate;
use app\admin\validate\login\CodeSignInValidate;
use app\admin\validate\login\MiniValidate;
use app\admin\validate\login\SignUpValidate;
use app\common\controller\BackendController;
use app\common\facade\TokenFacade;
use app\common\model\UserModel;
use app\common\model\UserWeixinBindModel;
use Fairy\Annotation\RequestParam;
use Fairy\Annotation\Validator;
use think\Request;
use utils\MyToolkit;

class LoginController extends BackendController
{
    /**
     * 登录
     * @RequestParam(fields={"username", "password", "type":1}, method="post")
     */
    public function signIn(Request $request)
    {
        $requestParam = $request->requestParam;
        $result = $this->validate($requestParam, $requestParam['type'] == UserModel::LOGIN_TYPE_PASSWORD ?
            AccountSignInValidate::class :
            CodeSignInValidate::class
        );
        if (true !== $result) {
            return MyToolkit::validate('', $result);
        }
        $userModel = new UserModel();
        $userInfo = $requestParam['type'] == UserModel::LOGIN_TYPE_PASSWORD ?
            $userModel->getByUsername($requestParam['username']) :
            $userModel->getByMobile($requestParam['username']);

        if (is_null($userInfo)) {
            return MyToolkit::error('', '账号不存在');
        } elseif ($userInfo['user_status'] == UserModel::STATUS_DISABLE) {
            return MyToolkit::error('', '账号被禁用');
        } elseif ($requestParam['type'] == UserModel::LOGIN_TYPE_PASSWORD) {
            $bool = MyToolkit::checkBcrypt($requestParam['password'], $userInfo['user_password']);
            if (!$bool) {
                return MyToolkit::error('', '用户名或密码错误');
            }
        }

        $accessTokenExp = config('system.token.access_token.exp');
        $accessToken = TokenFacade::encode(MyToolkit::enHashid($userInfo['user_id']), $accessTokenExp);
        $refreshToken = TokenFacade::encode('', config('system.token.refresh_token.exp'));
        $userModel->updateRefreshToken($refreshToken, $userInfo['user_id']);

        return MyToolkit::success([
            'access_token' => $accessToken,
            'expires_in' => $accessTokenExp,
            'refresh_token' => $refreshToken,
        ]);
    }

    /**
     * 用户注册
     * @Validator(class=SignUpValidate::class)
     * @RequestParam(fields={"user_name","user_password","user_nickname","user_mobile"},method="post")
     */
    public function singUp(Request $request)
    {
        $requestParam = $request->requestParam;
        $requestParam['user_password'] = MyToolkit::bcrypt($requestParam['user_password']);
        $userModel = new UserModel();

        return MyToolkit::success($userModel->singUp($requestParam));
    }

    /**
     * 退出登录
     */
    public function signOut(Request $request)
    {
        $refreshToken = $request->post('refresh_token');
        $userModel = new UserModel();

        return MyToolkit::success($userModel->clearRefreshToken($refreshToken) > 0);
    }

    /**
     * token有效性检测
     */
    public function check(Request $request)
    {
        $jwt = $request->header('Authorization');
        $data = TokenFacade::decode($jwt);

        return MyToolkit::success(['is_valid' => $data ? true : false, 'access_token' => $jwt]);
    }

    /**
     * 刷新access_token
     */
    public function refresh(Request $request)
    {
        $refreshToken = $request->post('refresh_token');
        $data = TokenFacade::decode($refreshToken);
        if ($data === false) {
            return MyToolkit::login('', TokenFacade::getError());
        }
        $userModel = new UserModel();
        $userInfo = $userModel->getByRefreshToken($refreshToken);
        if (is_null($userInfo)) {
            return MyToolkit::login();
        }

        return MyToolkit::success([
            'access_token' => TokenFacade::encode(MyToolkit::enHashid($userInfo['user_id']), config('system.token.access_token.exp'))
        ]);
    }

    /**
     * 小程序自动登录
     * @Validator(class=MiniValidate::class)
     */
    public function mini(Request $request)
    {
        $openid = $request->post('openid');
        $userBindModel = new UserWeixinBindModel();
        $uid = $userBindModel->getUserIdByOpenid($openid, UserWeixinBindModel::MINI_PROGRAM);
        if (is_null($uid)) {
            return MyToolkit::login();
        }

        $accessTokenExp = config('system.token.access_token.exp');
        $accessToken = TokenFacade::encode(MyToolkit::enHashid($uid), $accessTokenExp);
        $refreshToken = TokenFacade::encode('', config('system.token.refresh_token.exp'));
        $userModel = new UserModel();
        $userModel->updateRefreshToken($refreshToken, $uid);

        return MyToolkit::success([
            'access_token' => $accessToken,
            'expires_in' => $accessTokenExp,
            'refresh_token' => $refreshToken,
        ]);
    }

    /**
     * 终端绑定
     * @Validator(class=BindValidate::class)
     * @RequestParam(fields={"openid","type"},method="post")
     */
    public function bind(Request $request)
    {
        $requestParam = $request->requestParam;
        $userBindModel = new UserWeixinBindModel();
        $bool = $userBindModel->bindTerminal($request->userId, $requestParam['openid'], $requestParam['type']);

        return MyToolkit::success($bool);
    }
}
