<?php namespace App\Model;

class User extends \Eloquent {

	protected $table = 'user';
    protected $roleTable = 'role';
    protected $departmentTable = 'department';

    /**
     * 获取用户信息，并包含用户的部门名称、角色名称
     *
     * @param $keyword
     * @param $limit
     * @param $offset
     * @return array
     */
    public function getUsers($keyword, $offset, $limit) {
        $sql = "select t1.*, t2.name as roleName, t3.name as departmentName ";
        $sql .="from $this->table as t1 ";
        $sql .= "left join $this->roleTable as t2 on t1.role_id = t2.id ";
        $sql .= "left join $this->departmentTable as t3 on t1.department_id = t3.id ";
        if($keyword) {
            $sql .= "where t1.name like '%$keyword%' or t1.realname like '%$keyword%'  ";
        }
        $sql .= "order by status asc, id asc ";
        if($limit > 0) {
            $sql .= "limit $offset, $limit";
        }
        return \DB::select($sql);
    }

    /**
     * 按主键获取一个用户信息，并包含该用户的角色名称和部门名称
     *
     * @param $id
     * @return mixed
     */
    public function getUserById($id) {
        $sql = "select t1.*, t2.name as roleName, t3.name as departmentName ";
        $sql .="from $this->table as t1 ";
        $sql .= "left join $this->roleTable as t2 on t1.role_id = t2.id ";
        $sql .= "left join $this->departmentTable as t3 on t1.department_id = t3.id ";
        $sql .="where t1.id = $id";
        $result =  \DB::select($sql);
        if(count($result)) {
            return $result[0];
        }
        return $result;
    }
}
