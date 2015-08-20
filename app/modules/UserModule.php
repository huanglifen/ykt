<?php  namespace App\Module;

use App\Model\User;

/**
 * 用户module层
 *
 * @package App\Module
 */
class UserModule extends BaseModule {
    const STATUS_ADMIN = 0; //默认用户，不能删除

    /**
     * 新增一个用户
     *
     * @param $name
     * @param $password
     * @param $realName
     * @param $roleId   角色id
     * @param $departmentId 部门id
     * @param $tel
     * @param $mail
     * @param $status
     * @return array
     */
    public static function addUser($name, $password, $realName, $roleId, $departmentId, $tel, $mail, $status) {
        $has = self::checkUserExist($name);
        if($has) {
            return array('status' => false, 'msg' => array('name' => '用户名已经存在'));
        }
        $user = new User();
        $user->name = $name;
        $user->password = self::hash($password);
        $user->realname = $realName;
        $user->role_id = $roleId;
        $user->department_id = $departmentId;
        $user->tel = $tel;
        $user->mail = $mail;
        $user->status = $status;

        $user->save();
        return array('status' => true, 'id' => $user->id);
    }

    /**
     * 批量删除用户
     *
     * @param $ids
     * @return array
     */
    public static function deleteUserByIds($ids) {
        $failArr = array();
        foreach($ids as $id) {
            $result = self::deleteUserById($id);
            if(! $result['status']) {
                $failArr[] = $id;
            }
        }
        if(count($failArr)) {
            return array('status' => false, 'msg' => 'error_some_user_delete_fail');
        }
        return array('status' => true);
    }

    /**
     * 按主键删除一个用户
     *
     * @param $id
     * @return array
     */
    public static function deleteUserById($id) {
        $user = User::find($id);
        if($user->status == self::STATUS_ADMIN) {
            return array('status' => false, 'msg' => 'error_admin_cannot_delete');
        }
        $name = $user->name;

        User::destroy($id);
        return array('status' => true, 'id' => $id, 'name' => $name);
    }

    /**
     * 按主键更新一个用户信息
     *
     * @param $id
     * @param $name
     * @param $realName
     * @param $roleId
     * @param $departmentId
     * @param $tel
     * @param $mail
     * @param $status
     *
     * @return array
     */
    public static function updateUser($id, $realName, $roleId, $departmentId, $tel, $mail, $status) {
        $user = User::find($id);
        if(empty($user)) {
            return array('status' => true);
        }
        $user->realname = $realName;
        if($roleId) {
            $user->role_id = $roleId;
        }
        $user->department_id = $departmentId;
        $user->tel = $tel;
        $user->mail = $mail;
        if(! in_array($status , array(self::STATUS_CLOSE, self::STATUS_OPEN))) {
            $status = self::STATUS_OPEN;
        }
        if($user->status != self::STATUS_ADMIN) {
            $user->status = $status;
        }

        $user->update();
        return array('status' => true, 'id' => $user->id, 'name' => $user->name);
    }

    /**
     * 修改用户状态
     * 管理员用户状态不能修改
     *
     * @param $id
     * @return array
     */
    public static function updateUserStatus($id) {
        $user = User::find($id);
        if(empty($user)) {
            return array('status' => true);
        }

        if($user->status == self::STATUS_ADMIN) {
            return array('status' => false, 'msg' => 'error_cannot_change_admin_status');
        }

        if($user->status == self::STATUS_OPEN) {
            $user->status = self::STATUS_CLOSE;
        } else {
            $user->status = self::STATUS_OPEN;
        }
        $user->update();

        return array('status' => true, 'state' => $user->status, 'name' => $user->name);
    }

    /**
     * 更新用户密码
     *
     * @param $userId
     * @param $password
     * @param $newpassword
     * @return array
     */
    public static function updatePassword($userId, $password, $newpassword) {
        $user = User::find($userId);
        if(! self::checkHash($password, $user->password)) {
            return array('status' => false, 'msg' => array('password' => '1001'));
        }
        $user->password = self::hash($newpassword);
        $user->save();
        return array('status' => true);
    }

    /**
     * 按关键字获取用户记录
     *
     * @param $keyword
     * @param $offset
     * @param $limit
     * @return array
     */
    public static function getUsers($keyword, $offset, $limit) {
        $user = new User();
        $result = $user->getUsers($keyword, $offset, $limit);
        return $result;
    }

    /**
     * 按关键字统计用户
     *
     * @param $keyword
     * @return int
     */
    public static function countUsers($keyword) {
        if($keyword) {
           return User::where('name', 'like', "%$keyword%")->orWhere('realname', 'like', "%$keyword%")->count();
        }
        return User::count();
    }

    /**
     * 按主键获取用户信息
     *
     * @param $id
     * @return mixed
     */
    public static function getUserById($id) {
        $user = new User();
        return $user->getUserById($id);
    }

    /**
     * 验证用户登录
     *
     * @param $name
     * @param $password
     * @return array
     */
    public static function checkUser($name, $password) {
       $user = User::where('name', $name)->where('status', '!=', self::STATUS_CLOSE)->first();
        if(empty($user)) {
            return array('status' => false, 'msg' => 'error_login_fail');
        }

        $result = self::checkHash($password, $user->password);
        if(! $result) {
            return array('status' => false, 'msg' => 'error_login_fail');
        }

        $last_time = $user->last_login_time;
        $user->last_login_time = date("Y-m-d H:i:s", time());
        $user->login_count = intval($user->login_count) + 1;
        $user->save();
        return array('status' => true, 'user' => $user, 'last_time' => $last_time);
    }

    /**
     * 判断用户是否已经存在
     *
     * @param $name
     * @return bool
     */
    protected static function checkUserExist($name) {
        $count = User::where('name', $name)->count();
        return  $count ? true : false;
    }
}