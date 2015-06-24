<?php namespace App\Model;

class Permission extends \Eloquent {
    protected $table = "role_permission";

    public function addPermissionsByRoleId($roleId, $menuIds) {
        $permissions = array();
        $now = date("Y-m-d H:i:s", time());
        foreach($menuIds as $menu) {
            $permission = array('role_id' => $roleId, 'menu_id' => $menu, 'created_at' => $now, 'updated_at' => $now);
            $permissions[] = $permission;
        }
        \DB::table($this->table)->insert($permissions);
        return true;
    }
}