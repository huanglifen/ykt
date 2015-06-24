<?php namespace App\Module;

use App\Model\Department;

/**
 * 部门module层
 * @package App\Module
 */
class DepartmentModule extends BaseModule {
    const MAX_CHILD = 999; //最多子部门数
    const DEFAULT_PARENT = 0;

    /**
     * 添加一个部门
     *
     * @param $name
     * @param $superior_id
     * @param $description
     * @param $sort
     * @param $status
     * @return array
     */
    public static function addDepartment($name, $superior_id, $description, $sort, $status) {
        if($superior_id) {
            $parent = self::getDepartmentById($superior_id);
        }else{
            $parent = new Department();
            $parent->number = '';
        }
        $number = self::generateDepartmentNumber($superior_id, $parent->number);
        $department = new Department();
        $department->name = $name;
        $department->superior_id = $superior_id;
        $department->number = $number;
        $department->description = $description;
        $department->sort = $sort;
        $department->status = $status;
        $department->save();

        return array('status' => true, 'id' => $department->id);
    }

    /**
     * 按主键数组删除一个或者多个部门
     *
     * @param $ids
     * @return array
     */
    public static function deleteDepartmentsByIds($ids) {
        if(count($ids) > 1) {
            rsort($ids);
        }
        $failure = array();
        foreach($ids as $id) {
            $result = self::deleteDepartmentById($ids);
            if(! $result['status']) {
                $failure[] = $id;
            }
        }
        if(count($failure)) {
          return array('status' => false, 'msg' => 'error_some_department_has_child');
        }
        return array('status' => true);
    }

    /**
     * 按主键删除一个部门
     * $id也可以是数组，实现删除多个部门记录
     *
     * @param $id
     * @return array
     */
    public static function deleteDepartmentById($id) {
        $has = self::checkHasChild($id);
        if($has) {
            return array('status' => false, 'msg' => 'error_department_has_children');
        }
        Department::destroy($id);
        return array('status' => true);
    }


    /**
     * 按主键更新部门
     *
     * @param $id
     * @param $name
     * @param $description
     * @param $sort
     * @param $status
     * @return array
     */
    public static function updateDepartmentById($id, $name, $description, $sort, $status) {
        $department = Department::find($id);
        if(empty($department)) {
            return array('status' => true);
        }

        $department->name = $name;
        $department->description = $description;
        $department->sort = $sort;
        $department->status = $status;
        $department->save();

        return array('status' => true, 'id' => $id);
    }

    /**
     * 按主键更新部门状态
     *
     * @param $id
     * @return array
     */
    public static function updateDepartmentStatusById($id) {
        $department = Department::find($id);
        if(empty($department)) {
            return array('status' => true);
        }

        if($department->status == self::STATUS_OPEN) {
            $department->status = self::STATUS_CLOSE;
        }else{
            $department->status = self::STATUS_OPEN;
        }
        $department->save();

        $name = $department->name;
        return array('status' => true, 'state' => $department->status, 'name' => $name);
    }

    /**
     * 按条件获取部门记录
     *
     * @param $offset
     * @param $limit
     * @param string $keyword
     * @return array
     */
    public static function getDepartments($offset, $limit, $keyword = '') {
        $department = new Department();
        $results = $department->getDepartments($offset, $limit, $keyword);
        return $results;
    }

    /**
     * 按条件统计部门总数
     *
     * @param $keyword
     * @return int
     */
    public static function countDepartments($keyword) {
        if($keyword) {
            $count = Department::where('name', 'like', "%$keyword%")->orwhere('number', 'like', "%$keyword%")->count();
        }else{
            $count = Department::count();
        }
        return $count;
    }

    /**
     * 按主键获取部门,并包含该部门的上级部门名称
     *
     * @param $id
     * @return \Illuminate\Support\Collection|null|static
     */
    public static function getDepartmentById($id) {
        $department = new Department();
        return $department->getDepartmentAndParentNameById($id);
    }

    /**
     * 获取新建部门时可以选择的上级部门
     *
     * @return mixed
     */
    public static function getSuperDepartments() {
        $departments = new Department();
        return $departments->getSuperDepartments();
    }

    /**
     * 按状态获取部门
     *
     * @param int $status
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getDepartmentByStatus($status = self::STATUS_OPEN) {
        return Department::where('status', $status)->get();
    }

    /**
     * 生成部门编号
     *
     * @param int $parentId
     * @param string @parentNo
     * @return string
     */
    protected static function generateDepartmentNumber($parentId = self::DEFAULT_PARENT, $parentNo) {
        $last = Department::where('superior_id', $parentId)->orderBy('created_at', 'desc')->first();

        if($last) {
            $last = intval(substr($last->number, -1, 2));
            if($last >= self::MAX_CHILD) {
                return false;
            }
            $no = str_pad($last + 1, 2, '0', STR_PAD_LEFT);
        }else {
            $no = '01';
        }
        $number = $parentNo . $no;
        return $number;
    }

    /**
     * 检查部门是否还有子部门
     *
     * @param $id
     * @return bool
     */
    protected static function checkHasChild($id) {
        $result = Department::where('superior_id', $id)->count();
        return $result ? true : false;
    }
}