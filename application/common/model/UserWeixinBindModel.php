<?php

namespace app\common\model;

use think\Db;
use think\Model;

class UserWeixinBindModel extends Model
{
    const MINI_PROGRAM = 1;
    const WEIXIN_BROWSER = 2;

    protected $table = 'user_weixin_bind';

    public function getUserIdByOpenid($openid, $type)
    {
        return Db::table($this->table)
            ->where('openid', $openid)
            ->where('type', $type)
            ->value('uid');
    }

    public function bindTerminal($userId, $openid, $type)
    {
        $count = Db::table($this->table)
            ->where('user_id', $userId)
            ->where('type', $type)
            ->count();
        if ($count) {
            return Db::table($this->table)
                ->where('user_id', $userId)
                ->where('type', $type)
                ->update(['openid' => $openid]);
        } else {
            return Db::table($this->table)->insert(['user_id' => $userId, 'openid' => $openid, 'type' => $type]);
        }
    }
}
