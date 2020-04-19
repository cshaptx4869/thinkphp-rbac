<?php


namespace app\common\facade;

use think\Facade;
use utils\Token;

/**
 * @see Token
 * @method Token encode($data = '', $exp = null, $nbf = null, $iat = null, $iss = null, $aud = null) static 生成jwt
 * @method Token decode($jwt, $leeway = 60) static 解析jwt
 * @method Token getError() static 获取错误
 */
class TokenFacade extends Facade
{
    protected static function getFacadeClass()
    {
        return Token::class;
    }
}
