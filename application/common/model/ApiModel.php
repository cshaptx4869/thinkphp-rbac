<?php

namespace app\common\model;

use app\common\traits\AutoTimestampTrait;
use think\Db;
use think\db\Query;
use think\Model;
use utils\MyToolkit;

class ApiModel extends Model
{
    use AutoTimestampTrait;

    const METHOD_GET = 'get';
    const METHOD_POST = 'post';
    const METHOD_PUT = 'put';
    const METHOD_DELETE = 'delete';

    protected $table = 'api';

    public static function methodText()
    {
        return [
            self::METHOD_GET => self::METHOD_GET,
            self::METHOD_POST => self::METHOD_POST,
            self::METHOD_PUT => self::METHOD_PUT,
            self::METHOD_DELETE => self::METHOD_DELETE
        ];
    }

    public function apiIndex(array $params)
    {
        $qb = Db::table($this->table)
            ->field('api_id,api_name,api_route,api_method,api_desc,created_at');
        $this->apiIndexCondition($qb, $params);
        if (!$count = $qb->count()) {
            return MyToolkit::paginate([], $params['page'], $params['limit'], 0);
        }
        $apis = $qb->page($params['page'], $params['limit'])
            ->order('api_sort_order')
            ->select();

        $data = [];
        foreach ($apis as $api) {
            $api['created_at'] = $api['created_at'] ? date('Y-m-d H:i:s', $api['created_at']) : '';
            $data[] = $api;
        }

        return MyToolkit::paginate($data, $params['page'], $params['limit'], $count);
    }

    public function apiIndexCondition(Query $qb, array $params)
    {
        if ($params['api_name']) {
            $qb->whereLike('api_name', '%' . $params['api_name'] . '%');
        }
    }

    public function getApiByApiIds(array $apiIds)
    {
        return Db::table($this->table)
            ->whereIn('api_id', $apiIds)
            ->select();
    }

    public function apiStore(array $params)
    {
        $this->autoTimestamp($params);

        return Db::table($this->table)->insert($params) > 0;
    }

    public function apiShow($apiId)
    {
        return Db::table($this->table)
            ->where('api_id', $apiId)
            ->field('api_id,api_name,api_route,api_method,api_desc,api_sort_order')
            ->find();
    }

    public function apiUpdate($apiId, array $params)
    {
        $this->updatedAt($params);

        return Db::table($this->table)
                ->where('api_id', $apiId)
                ->update($params) > 0;
    }

    public function apiDestroy($apiId)
    {
        return Db::table($this->table)
                ->where('api_id', $apiId)
                ->delete() > 0;
    }

    public function apiIds()
    {
        return Db::table($this->table)->column('api_id');
    }

    public function apis()
    {
        return Db::table($this->table)
            ->field('api_id,api_name,api_route,api_method')
            ->select();
    }
}
