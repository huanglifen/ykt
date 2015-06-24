<?php namespace App\Module;

use App\Model\Permission;

/**
 * 权限module层
 *
 * Class PermissionModule
 * @package App\Module
 */
class PermissionModule extends BaseModule {

    /**
     * 为一个角色新增权限
     *
     * @param $roleId
     * @param $menuIds
     * @return array
     */
    public static function addPermissionByRole($roleId, $menuIds) {
        Permission::where('role_id', $roleId)->delete();
        $permission = new Permission();
        $permission->addPermissionsByRoleId($roleId, $menuIds);
        return array('status' => true);
    }

    /**
     * 获取一个角色的所有权限信息
     *
     * @param $roleId
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getPermissionByRoleId($roleId) {
        $permissions = Permission::where("role_id", $roleId)->get(['menu_id']);
        $per = array();
        foreach($permissions as $p) {
            $per[] = $p->menu_id;
        }
        return $per;
    }
}