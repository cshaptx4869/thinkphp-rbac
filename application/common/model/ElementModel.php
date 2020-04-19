<?php

namespace app\common\model;

use app\common\traits\AutoTimestampTrait;
use think\Db;
use think\db\Query;
use think\Model;
use utils\MyToolkit;

class ElementModel extends Model
{
    use AutoTimestampTrait;

    const TYPE_PAGE = 'page';
    const TYPE_BLOCK = 'block';

    protected $table = 'element';

    public static function typeText()
    {
        return [
            self::TYPE_BLOCK => '块组件',
            self::TYPE_PAGE => '页面'
        ];
    }

    public function elementIndex(array $params)
    {
        $qb = Db::table($this->table)
            ->field('element_id,element_name,element_type,element_code,element_desc,created_at');

        $this->elementIndexCondition($qb, $params);
        if (!$count = $qb->count()) {
            return MyToolkit::paginate([], $params['page'], $params['limit'], 0);
        }

        $elements = $qb->page($params['page'], $params['limit'])
            ->order('element_sort_order')
            ->select();

        $elementIds = array_column($elements, 'element_id');
        $elementApiModel = new ElementApiModel();
        $elementApiData = $elementApiModel->getElementApiByElementIds($elementIds);
        $elementApiMap = MyToolkit::setArray2Column($elementApiData, 'element_id', 'api_name');

        $data = [];
        foreach ($elements as $element) {
            $element['created_at'] = $element['created_at'] ? date('Y-m-d H:i:s', $element['created_at']) : '';
            $element['api_name'] = isset($elementApiMap[$element['element_id']]) ? $elementApiMap[$element['element_id']] : [];
            $data[] = $element;
        }

        return MyToolkit::paginate($data, $params['page'], $params['limit'], $count);
    }

    public function elementIndexCondition(Query $qb, array $params)
    {
        if ($params['element_name']) {
            $qb->whereLike('element_name', '%' . $params['element_name'] . '%');
        }
    }

    public function elementPreview()
    {
        $apiModel = new ApiModel();

        return [
            'element_type' => MyToolkit::convertToArray(self::typeText()),
            'api' => $apiModel->apis()
        ];
    }

    public function getElementByElementIds(array $elementIds)
    {
        return Db::table($this->table)->whereIn('element_id', $elementIds)->select();
    }

    public function elementStore(array $params)
    {
        $elementData = [
            'element_name' => $params['element_name'],
            'element_type' => $params['element_type'],
            'element_code' => $params['element_code'],
            'element_desc' => $params['element_desc'],
            'element_sort_order' => $params['element_sort_order'],
        ];
        $this->autoTimestamp($elementData);

        Db::startTrans();
        try {
            $elementId = Db::table($this->table)->insertGetId($elementData);
            if ($params['api_ids']) {
                $elementApiModel = new ElementApiModel();
                $elementApiModel->elementApiStore($elementId, $params['api_ids']);
            }
            Db::commit();

            return true;
        } catch (\Exception $e) {
            Db::rollback();

            return false;
        }
    }

    public function elementShow($elementId)
    {
        $elementData = Db::table($this->table)
            ->where('element_id', $elementId)
            ->field('element_id,element_name,element_code,element_type,element_desc,element_sort_order')
            ->find();
        if (empty($elementData)) {
            return [];
        }
        $elementApiModel = new ElementApiModel();
        $elementData['api_ids'] = $elementApiModel->getApiByElementId($elementId);

        return $elementData;
    }

    public function elementUpdate($elementId, array $params)
    {
        $elementData = [
            'element_name' => $params['element_name'],
            'element_type' => $params['element_type'],
            'element_code' => $params['element_code'],
            'element_desc' => $params['element_desc'],
            'element_sort_order' => $params['element_sort_order'],
        ];
        $this->updatedAt($elementData);

        Db::startTrans();
        try {
            Db::table($this->table)
                ->where('element_id', $elementId)
                ->update($elementData);
            if ($params['api_ids']) {
                $elementApiModel = new ElementApiModel();
                $elementApiModel->elementApiUpdate($elementId, $params['api_ids']);
            }
            Db::commit();

            return true;
        } catch (\Exception $e) {
            Db::rollback();

            return false;
        }
    }

    public function elementDestroy($elementId)
    {
        Db::startTrans();
        try {
            Db::table($this->table)
                ->where('element_id', $elementId)
                ->delete();
            $elementApiModel = new ElementApiModel();
            $elementApiModel->elementApiDestroy($elementId);
            Db::commit();

            return true;
        } catch (\Exception $e) {
            Db::rollback();

            return false;
        }
    }

    public function elements()
    {
        return Db::table($this->table)
            ->field('element_id,element_name')
            ->select();
    }
}
