<?php


namespace utils;

use Hashids\Hashids;

class MyToolkit
{
    const SUCCESS_CODE = 200;
    const LOGIN_CODE = 401;
    const AUTH_CODE = 403;
    const VALIDATE_CODE = 422;
    const ERROR_CODE = 500;

    public static function success($data = '', $msg = '信息调用成功！')
    {
        return self::returnData($data, $msg, self::SUCCESS_CODE);
    }

    public static function error($data = '', $msg = '信息调用成功！')
    {
        return self::returnData($data, $msg, self::ERROR_CODE);
    }

    public static function validate($data = '', $msg = '验证错误！')
    {
        return self::returnData($data, $msg, self::VALIDATE_CODE);
    }

    public static function login($data = '', $msg = '请先登录！')
    {
        return self::returnData($data, $msg, self::LOGIN_CODE);
    }

    public static function auth($data = '', $msg = '没有权限！')
    {
        return self::returnData($data, $msg, self::AUTH_CODE);
    }

    public static function returnData($data = '', $msg = '信息调用成功！', $code = 200)
    {
        return ['code' => $code, 'data' => $data, 'msg' => $msg, 'time' => request()->time()];
    }

    public static function paginate($data, $page, $limit, $total)
    {
        return [
            'items' => $data, 'page' => (int)$page, 'limit' => (int)$limit, 'total' => $total, 'pages' => ceil($total / $limit)
        ];
    }

    /**
     * 密码加密
     * @param $password
     * @return bool|string
     */
    public static function bcrypt($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * 验证bcrypt的密码是否正确
     * @param $password
     * @param $hash
     * @return bool
     */
    public static function checkBcrypt($password, $hash)
    {
        return password_verify($password, $hash);
    }

    /**
     * 加密数字
     * @param $id
     * @return string
     */
    public static function enHashid($id)
    {
        $hashids = new Hashids('!@#$)(%^&*', 10);

        return $hashids->encode($id);
    }

    /**
     * 解密数字
     * @param $id
     * @return array
     */
    public static function deHashid($id)
    {
        $hashids = new Hashids('!@#$)(%^&*', 10);

        return $hashids->decode($id);
    }

    public static function convertToArray($items)
    {
        $result = [];
        foreach ($items as $k => $v) {
            $result[] = [
                'text' => $v,
                'value' => $k
            ];
        }

        return $result;
    }

    public static function setArrayIndex($arr, $key)
    {
        $newarr = [];
        foreach ($arr as $k => $v) {
            $newarr[$v[$key]] = $v;
        }

        return $newarr;
    }

    public static function setArray2Index(array $arr, $key)
    {
        $newArr = [];
        foreach ($arr as $k => $v) {
            if (is_array($v)) {
                $newArr[$v[$key]][] = $v;
            }
        }

        return $newArr;
    }

    public static function setArray2Column(array $arr, $key, $value)
    {
        $newArr = [];
        foreach ($arr as $k => $v) {
            $newArr[$v[$key]][] = $v[$value];
        }

        return $newArr;
    }

    /**
     * 数组转树状结构
     * @param array $data
     * @param string $fields
     * @param int $parentId
     * @param int $level
     * @param bool $allowChildEmpty 是否显示空的子节点
     * @return array
     */
    public static function makeTree(array $data, $fields = 'id|pid|children|_level', $parentId = 0, $level = 1, $allowChildEmpty = true)
    {
        $tree = [];
        list($idField, $pidField, $childField, $levelField) = explode('|', $fields);
        foreach ($data as $k => $v) {
            if ($v[$pidField] == $parentId) {
                $v[$levelField] = $level;
                unset($data[$k]);
                $childData = self::makeTree($data, $fields, $v[$idField], $level + 1);
                if ($childData || $allowChildEmpty) {
                    $v[$childField] = $childData;
                }
                $tree[] = $v;
            }
        }

        return $tree;
    }

    public static function timeDiff($beginTime, $endTime)
    {
        if ($beginTime > $endTime) {
            return ["day" => 0, "hour" => 0, "min" => 0, "sec" => 0];
        }

        $diffTime = $endTime - $beginTime;
        $days = intval($diffTime / 86400);
        $remain = $diffTime % 86400;
        $hours = intval($remain / 3600);
        $remain = $remain % 3600;
        $mins = intval($remain / 60);
        $secs = $remain % 60;

        return ["day" => $days, "hour" => $hours, "min" => $mins, "sec" => $secs];
    }
}
