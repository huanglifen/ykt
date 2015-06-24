<?php namespace App\Model;
/**
 * 日志model层
 * @package App\Model
 */
class Log extends \Eloquent {
    protected $table = 'log';
    protected $roleTable = 'role';
    protected $departmentTable = 'department';
    protected $userTable = 'user';
    public $timestamps = false;

    public function getLogs($userId, $begin, $end, $offset, $limit) {
        $sql = "select t1.*, t4.name as accountName, t2.name as roleName, t3.name as departmentName ";
        $sql .= "from $this->table as t1 ";
        $sql .= "left join $this->userTable as t4 on t4.id = t1.user_id ";
        $sql .= "left join $this->roleTable as t2 on t4.role_id = t2.id ";
        $sql .= "left join $this->departmentTable as t3 on t4.department_id = t3.id ";
        $where = '';
        if ($userId) {
            $where .= "t1.user_id='$userId' ";
        }
        if ($begin) {
            if ($where) {
                $where .= " and ";
            }
            $where .= "t1.time >= '$begin' ";
        }
        if ($end) {
            if ($where) {
                $where .= " and ";
            }
            $where .= "t1.time < '$end' ";
        }
        if ($where) {
            $sql .= " where $where";
        }
        $sql .= " order by t1.time desc ";
        if ($limit > 0) {
            $sql .= "limit $offset, $limit ";
        }
        return \DB::select($sql);
    }
}