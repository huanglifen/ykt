<?php  namespace App\Module;

use App\Model\Role;

/**
 * 角色module层
 *
 * Class RoleModule
 * @package App\Module
 */
class RoleModule extends BaseModule
{
    /**
     * 添加一个角色
     *
     * @param $name
     * @param $description
     * @param $sort
     * @param $status
     * @return array
     */
    public static function addRole($name, $description, $sort, $status) {
        $role = new Role();
        $role->name = $name;
        $role->description = $description;
        $role->sort = $sort;
        $role->status = $status;
        $role->save();
        return array('status' => true, 'id' => $role->id);
    }

    /**
     * 按主键组删除一个或者多个角色
     *
     * @param $ids
     * @return array
     */
    public static function deleteRolesByIds($ids) {
        return self::deleteRoleById($ids);
    }

    /**
     * 按主键删除角色
     * $id变量其实也可以是数组，实现批量删除功能
     *
     * @param $id
     * @return array
     */
    public static function deleteRoleById($id) {
        Role::destroy($id);
        return array('status' => true);
    }

    /**
     * 根据主键更新角色
     *
     * @param $id
     * @param $name
     * @param $sort
     * @param $description
     * @param $status
     * @return array
     */
    public static function updateRoleById($id, $name, $sort, $description, $status) {
        $role = self::getRoleById($id);
        if(empty($role)) {
            return array('status' => true);
        }
        $role->name = $name;
        $role->sort = $sort;
        $role->description = $description;
        $role->status = $status;
        $role->save();

        return array('status' => true, 'id' => $id);
    }

    /**
     * 根据主键更新角色状态
     *
     * @param $id
     * @return array
     */
    public static function updateRoleStatusById($id) {
        $role = self::getRoleById($id);
        $name = $role->name;
        if(empty($role)) {
            return array('status' => true);
        }

        if($role->status == self::STATUS_OPEN) {
            $role->status = self::STATUS_CLOSE;
        } else {
            $role->status = self::STATUS_OPEN;
        }
        $role->save();

        return array('status' => true, 'state' => $role->status, 'name' => $name);
    }

    /**
     * 按主键获取一个角色信息
     *
     * @param $id
     * @return \Illuminate\Support\Collection|null|static
     */
    public static function getRoleById($id) {
        return Role::find($id);
    }

    /**
     * 按条件获取角色记录
     *
     * @param $offset
     * @param $limit
     * @param $keyword
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getRoles($offset, $limit, $keyword) {
        $roles = new Role();
        if($keyword) {
            $roles->where('name', 'like', "%$keyword%");
        }
        if($limit > 0) {
            $roles->offset($offset)->limit($limit);
        }
        $roles = $roles->get();
        return $roles;
    }

    /**
     * 按条件统计角色记录
     *
     * @param $keyword
     * @return int
     */
    public static function countRoles($keyword) {
        if($keyword) {
            $count = Role::where('name', 'like', "%$keyword%")->count();
        }else{
            $count = Role::count();
        }
        return $count;
    }

    /**
     * 按状态获取角色
     *
     * @param int $status
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getRolesByStatus($status = self::STATUS_OPEN) {
        return Role::where('status', $status)->get();
    }
}