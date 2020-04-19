<?php

namespace app\service\controller;

use app\common\facade\SmsSenderFacade;
use app\service\validate\index\EmailValidate;
use app\service\validate\index\SmsValidate;
use Fairy\Annotation\Validator;
use think\Controller;
use think\Request;
use utils\MyToolkit;
use utils\SmsSender;
use utils\SMTPMailSender;

class IndexController extends Controller
{
    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:) </h1><p> ThinkPHP V5.1<br/><span style="font-size:30px">12载初心不改（2006-2018） - 你值得信赖的PHP框架</span></p></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=64890268" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="eab4b9f840753f8e7"></think>';
    }

    public function hello($name = 'ThinkPHP5')
    {
        return MyToolkit::success('hello,' . $name);
    }

    public function miss(Request $request)
    {
        if ($request->isOptions()) {
            return MyToolkit::success();
        } else {
            return MyToolkit::error('', '没有匹配到对应路由');
        }
    }

    /**
     * 发送短信
     * @Validator(class=SmsValidate::class)
     */
    public function sendSms(Request $request)
    {
        $mobile = $request->post('mobile');
        $smsObj = new SmsSender();
        $bool = $smsObj->send($mobile);

        return $bool ? MyToolkit::success() : MyToolkit::error('', $smsObj->getError());
    }

    /**
     * 发送邮件
     * @Validator(class=EmailValidate::class)
     */
    public function sendEmail(Request $request)
    {
        $email = $request->post('email');
        $emailObj = new SMTPMailSender();
        $bool = $emailObj->addAddress($email)
            ->setContent('PHPMailer发送验证码', '<p>验证码: ' . mt_rand(000000, 999999) . '</p>')
            ->sendMail();

        return $bool ? MyToolkit::success() : MyToolkit::error('', $emailObj->getError());
    }

    /**
     * 上传图片
     */
    public function uploadImage(Request $request)
    {
        $file = $request->file('image');
        if (is_null($file)) {
            return MyToolkit::error('', '请选择要上传的图片');
        }
        $moveDir = config('system.upload.image.dir');
        $info = $file->validate(config('system.upload.image.validate'))
            ->rule(config('system.upload.image.rule'))
            ->move($moveDir);
        if ($info) {
            return MyToolkit::success(['image_path' => config('app.app_host') . $moveDir . $info->getSaveName()]);
        } else {
            return MyToolkit::error('', $file->getError());
        }
    }
}
