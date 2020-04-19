<?php

namespace app\common\model;

use app\common\traits\AutoTimestampTrait;
use think\Db;
use think\Model;

class ElementApiModel extends Model
{
    use AutoTimestampTrait;

    protected $table = 'element_api';

    public function elementApiStore($elementId, array $apiIds)
    {
        $elementApiData = array_map(function ($apiId) use ($elementId) {
            $elementApi = ['element_id' => $elementId, 'api_id' => $apiId];
            $this->autoTimestamp($elementApi);

            return $elementApi;
        }, $apiIds);

        return Db::table($this->table)->insertAll($elementApiData) > 0;
    }

    public function elementApiUpdate($elementId, array $apiIds)
    {
        $originApiData = $this->getApiByElementId($elementId);
        $grantApiData = array_diff($apiIds, $originApiData);
        $revokeApiData = array_diff($originApiData, $apiIds);
        $grantApiData && $this->elementApiStore($elementId, $grantApiData);
        $revokeApiData && $this->elementApiDestroy($elementId, $revokeApiData);
    }

    public function elementApiDestroy($elementId, array $apiIds = [])
    {
        $qb = Db::table($this->table)->where('element_id', $elementId);
        if ($apiIds) {
            $qb->whereIn('api_id', $apiIds);
        }

        return $qb->delete();
    }

    /**
     * 通过 element_id 获取 api_id
     * @param int|array $elementId
     * @return array
     */
    public function getApiByElementId($elementId)
    {
        $qb = Db::table($this->table);
        is_array($elementId) ? $qb->whereIn('element_id', $elementId) : $qb->where('element_id', $elementId);

        return $qb->column('api_id');
    }

    public function getElementApiByElementIds(array $elementIds)
    {
        return Db::table($this->table)->alias('ea')
            ->join('api a', 'a.api_id=ea.api_id')
            ->field('ea.element_id,a.api_name')
            ->whereIn('ea.element_id', $elementIds)
            ->select();
    }
}
