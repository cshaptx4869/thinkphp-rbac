<?php


namespace app\common\facade;

use think\Facade;
use utils\SmsSender;

/**
 * @see SmsSender
 * @method SmsSender send($mobile) static 发送短信
 * @method SmsSender chooseTemplate($index) static 选择短信模板
 * @method SmsSender getSendTimes($mobile) static 获取当天该号码发送的次数
 * @method SmsSender isEffective($mobile, $code) static 验证码是否正确
 * @method SmsSender getSmsKey() static 获取缓存的sms_key
 * @method SmsSender getError() static 获取错误信息
 */
class SmsSenderFacade extends Facade
{
    protected static function getFacadeClass()
    {
        return SmsSender::class;
    }
}
