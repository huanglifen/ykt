<?php namespace App\Model;
use Illuminate\Support\Facades\DB;

/**
 * 部门管理model层
 * @package App\Model
 */
class Department extends \Eloquent {
    protected $table = "department";
    const MAX_LEVEL = 3;

    /**
     * 按条件获取部门记录，并包含该部门的上级部门名称
     *
     * @param $offset
     * @param $limit
     * @param $keyword
     * @return array
     */
    public function getDepartments($offset, $limit, $keyword) {
        $sql = "select t1.*,ifnull(t2.name, '无') as parent from $this->table as t1 ";
        $sql .= "left join (select id,name from $this->table) as t2 on t1.superior_id=t2.id ";
        if($keyword) {
            $sql .= " where t1.name like '%$keyword%' or t1.number like '%$keyword%' ";
        }
        $sql .= "order by number ";
        if($limit > 0) {
            $sql .= "limit $offset,$limit";
        }
        return \DB::select($sql);
    }

    /**
     * 获取可以选择的上级部门
     * 默认部门级别最多为3级，所以只选取部门级别为2的部门
     * @return mixed
     */
    public function getSuperDepartments() {
        $level = 2 * (self::MAX_LEVEL - 1);
        $sql = "select id, name, LENGTH(number) as level from department where LENGTH(number) <= $level";
        return DB::select($sql);
    }

    /**
     * 获取部门以及该部门的上级部门名称
     *
     * @param $id
     * @return mixed
     */
    public function getDepartmentAndParentNameById($id) {
        $sql = "select t1.*,ifnull(t2.name, '无') as parent from $this->table as t1 ";
        $sql .= "left join (select id,name from $this->table) as t2 on t1.superior_id=t2.id ";
        $sql .= "where t1.id='$id'";
        $department =  \DB::select($sql);
        if(count($department)) {
            return $department[0];
        }else {
            return $department;
        }

    }
}