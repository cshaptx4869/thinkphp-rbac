<?php

namespace app\common\model;

use app\common\traits\AutoTimestampTrait;
use http\Client\Curl\User;
use think\Db;
use think\db\Query;
use think\Model;
use utils\MyToolkit;

class UserModel extends Model
{
    use AutoTimestampTrait;

    const LOGIN_TYPE_MOBILE = 1;
    const LOGIN_TYPE_PASSWORD = 2;

    const STATUS_ENABLE = 0;
    const STATUS_DISABLE = 1;

    protected $table = 'user';
    protected $readonly = ['user_name'];
    protected $pk = 'user_id';

    public static function statusText()
    {
        return [
            self::STATUS_ENABLE => '启用',
            self::STATUS_DISABLE => '禁用'
        ];
    }

    public function userIndex(array $params)
    {
        $qb = Db::table($this->table);
        $this->userIndexCondition($qb, $params);
        if (!$count = $qb->count()) {
            return MyToolkit::paginate([], $params['page'], $params['limit'], 0);
        }
        $users = $qb->page($params['page'], $params['limit'])->select();
        $userIds = array_column($users, 'user_id');
        $userRoleModel = new UserRoleModel();
        $userRoleData = $userRoleModel->getUserRoleByUserIds($userIds);
        $userRoleMap = MyToolkit::setArray2Column($userRoleData, 'user_id', 'role_name');
        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'user_id' => $user['user_id'],
                'user_name' => $user['user_name'],
                'role_name' => isset($userRoleMap[$user['user_id']]) ? $userRoleMap[$user['user_id']] : [],
                'user_mobile' => $user['user_mobile'],
                'user_email' => $user['user_email'],
                'user_status' => $user['user_status'] == self::STATUS_ENABLE ? true : false,
                'created_at' => $user['created_at'] ? date('Y-m-d H:i:s', $user['created_at']) : '',
            ];
        }

        return MyToolkit::paginate($data, $params['page'], $params['limit'], $count);
    }

    public function userIndexCondition(Query $qb, array $params)
    {
        if ($params['user_name']) {
            $qb->whereLike('user_name', '%' . $params['user_name'] . '%');
        }
    }

    public function userPreview()
    {
        $roleModel = new RoleModel();

        return [
            'user_status' => MyToolkit::convertToArray(self::statusText()),
            'roles' => MyToolkit::convertToArray($roleModel->roles())
        ];
    }

    public function userStore(array $params)
    {
        $userData = [
            'user_name' => $params['user_name'],
            'user_password' => MyToolkit::bcrypt($params['user_password']),
            'user_mobile' => $params['user_mobile'],
            'user_email' => $params['user_email'],
        ];
        $this->autoTimestamp($userData);

        Db::startTrans();
        try {
            $userId = Db::table($this->table)->insertGetId($userData);
            $userRoleModel = new UserRoleModel();
            $userRoleModel->userRoleStore($userId, $params['role_ids']);
            Db::commit();

            return true;
        } catch (\Exception $e) {
            Db::rollback();

            return false;
        }
    }

    public function userShow($userId)
    {
        $userData = Db::table($this->table)
            ->where('user_id', $userId)
            ->field('user_id,user_name,user_mobile,user_email,user_status')
            ->find();
        if (empty($userData)) {
            return [];
        }
        $userRoleModel = new UserRoleModel();
        $userData['role_ids'] = $userRoleModel->getRoleByUserId($userId);

        return $userData;
    }

    public function userUpdate(array $params)
    {
        $userData = [
            'user_name' => $params['user_name'],
            'user_mobile' => $params['user_mobile'],
            'user_email' => $params['user_email'],
            'user_status' => $params['user_status']
        ];
        if (isset($params['user_password']) && $params['user_password']) {
            $userData['user_password'] = MyToolkit::bcrypt($params['user_password']);
        }
        $this->updatedAt($userData);

        Db::startTrans();
        try {
            Db::table($this->table)->where('user_id', $params['user_id'])->update($userData);
            $userRoleModel = new UserRoleModel();
            $userRoleModel->userRoleUpdate($params['user_id'], $params['role_ids']);
            Db::commit();

            return true;
        } catch (\Exception $e) {
            Db::rollback();

            return false;
        }
    }

    public function statusUpdate(array $params)
    {
        $userId = $params['user_id'];
        unset($params['user_id']);
        if ($params['user_status'] == self::STATUS_DISABLE) {
            $params['user_refresh_token'] = '';
        }
        $this->updatedAt($params);

        Db::table($this->table)->where('user_id', $userId)->update($params);

        return true;
    }

    public function userDestroy($userId)
    {
        Db::startTrans();
        try {
            Db::table($this->table)->where('user_id', $userId)->delete();
            $userRoleModel = new UserRoleModel();
            $userRoleModel->userRoleDestroy($userId);
            Db::commit();

            return true;
        } catch (\Exception $e) {
            Db::rollback();

            return false;
        }
    }

    public function getByUsername($username)
    {
        return Db::table($this->table)
            ->where('user_name', $username)
            ->find();
    }

    public function getByMobile($mobile)
    {
        return Db::table($this->table)
            ->where('user_mobile', $mobile)
            ->find();
    }

    public function getByRefreshToken($refreshToken)
    {
        return Db::table($this->table)
            ->where('user_refresh_token', $refreshToken)
            ->find();
    }

    public function updateRefreshToken($refreshToken, $userId)
    {
        return Db::table($this->table)
            ->where('user_id', $userId)
            ->update(['user_refresh_token' => $refreshToken]);
    }

    public function clearRefreshToken($refreshToken)
    {
        return Db::table($this->table)
            ->where('user_refresh_token', $refreshToken)
            ->update(['user_refresh_token' => '']);
    }

    public function singUp($postData)
    {
        return Db::table($this->table)->insert($postData);
    }

    public function uidUnameMap(array $userIds)
    {
        return Db::table($this->table)
            ->whereIn('user_id', $userIds)
            ->column('user_name', 'user_id');
    }

    public function getByUserId($userId, $filed = '*')
    {
        return $this->where('user_id', $userId)
            ->field($filed)
            ->find();
    }

    public function getValue($userId, $field)
    {
        return Db::table($this->table)
            ->where('user_id', $userId)
            ->value($field);
    }

    public function userPermission($userId)
    {
        $resourceData = $this->getResourceByUserId($userId);

        $menuModel = new MenuModel();
        $menuData = $resourceData['menu_id'] ? $menuModel->getMenuByMenuIds($resourceData['menu_id']) : [];

        $elementModel = new ElementModel();
        $elementData = $resourceData['element_id'] ? $elementModel->getElementByElementIds($resourceData['element_id']) : [];
        $pageElement = $blockElement = [];
        foreach ($elementData as $row) {
            if ($row['element_type'] == ElementModel::TYPE_PAGE) {
                $pageElement[] = $row['element_code'];
            } else {
                $blockElement[] = $row['element_code'];
            }
        }

        return [
            'menu' => MyToolkit::makeTree($menuData, 'menu_id|menu_parent_id|menu_children|menu_level'),
            'element' => [
                'page' => $pageElement,
                'block' => $blockElement
            ]
        ];
    }

    public function getResourceByUserId($userId)
    {
        $userRoleModel = new UserRoleModel();
        $roleId = $userRoleModel->getRoleByUserId($userId);

        $roleResourceModel = new RoleResourceModel();
        $resourceData = $roleId ? $roleResourceModel->getResourceByRoleId($roleId) : ['menu_id' => [], 'element_id' => []];

        return $resourceData;
    }
}
