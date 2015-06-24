<?php namespace App\Controllers;

use App\Module\DepartmentModule;
use App\Module\LogModule;

/**
 * 部门控制器
 *
 * @package App\Controllers
 */
class DepartmentController extends  BaseController {
    protected $langFile = 'previlege';

    /**
     * 显示部门页面
     *
     * @return \Illuminate\View\View
     */
    public function getIndex( ) {
        $isLogin = $this->isLogin();
        if(! $isLogin){
            return \Redirect::to('/login');
        }

        return $this->showView('main.departments');
    }

    /**
     * 按条件获取部门记录
     *
     * @return string
     */
    public function getDepartments() {
        $this->outputUserNotLogin();

        $keyword = $this->getParam('keyword');
        $offset = $this->getParam('iDisplayStart');
        $limit = $this->getParam('iDisplayLength');
        $limit = $limit ? $limit : DepartmentModule::NUM_PER_PAGE;

        $this->outputErrorIfExist();

        $departments = DepartmentModule::getDepartments($offset, $limit, $keyword);
        $total = DepartmentModule::countDepartments($keyword);
        $result = array('departments' => $departments, 'iTotalDisplayRecords' => $total, '_iRecordsTotal' => $total, 'iDisplayStart' => $offset, 'iDisplayLength' => $limit);

        return json_encode($result);
    }

    /**
     * 显示新增部门页面
     *
     * @return \Illuminate\View\View
     */
    public function getAdd() {
        $isLogin = $this->isLogin();
        if(! $isLogin){
            return \Redirect::to('/login');
        }

        $departments = DepartmentModule::getSuperDepartments();
        $this->data = compact('departments');
        return $this->showView('main.department-add');
    }

    /**
     * 新增部门请求
     *
     * @return string
     */
    public function postAdd() {
        $this->outputUserNotLogin();

        $name = htmlspecialchars($this->getParam('name', 'required'));
        $superiorId = $this->getParam('superiorId', 'required|numeric');
        $description = htmlspecialchars($this->getParam('description', 'required'));
        $sort = $this->getParam('sort', 'required|numeric');
        $status = $this->getParam('status', 'required|numeric');

        $this->outputErrorIfExist();

        $result = DepartmentModule::addDepartment($name, $superiorId, $description, $sort, $status);
        $this->outputErrorIfFail($result);

        $content ="新增部门:$name ";
        LogModule::log($content, LogModule::TYPE_ADD);
        return $this->outputContent($result['id']);
    }

    /**
     * 显示修改部门页面
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function getUpdate($id = 0) {
        $isLogin = $this->isLogin();
        if(! $isLogin){
            return \Redirect::to('/login');
        }

        $id = intval($id);
        if(! $id) {
            return \Redirect::to("department/index");
        }
        $department = DepartmentModule::getDepartmentById($id);

        if(empty($department)) {
           return \Redirect::to("department/index");
        }
        $this->data = compact('department');
        return $this->showView('main.department-update');
    }

    /**
     * 修改一个部门请求
     *
     * @return string
     */
    public function postUpdate() {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required|numeric');
        $name = $this->getParam('name', 'required');
        $sort = $this->getParam('sort', 'required|numeric');
        $description = $this->getParam('description', 'required');
        $status = $this->getParam('status', 'required|numeric');

        $this->outputErrorIfExist();

        $result = DepartmentModule::updateDepartmentById($id, $name, $description, $sort, $status);
        $this->outputErrorIfFail($result);

        $content ="修改部门:$name";
        LogModule::log($content, LogModule::TYPE_UPDATE);

        return $this->outputContent($result);
    }

    /**
     * 修改部门状态请求
     *
     * @return string
     */
    public function postStatus() {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required|numeric');
        $this->outputErrorIfExist();

        $result = DepartmentModule::updateDepartmentStatusById($id);
        $this->outputErrorIfFail($result);

        $name = $result['name'];
        $content ="修改部门:$name 的状态";
        LogModule::log($content, LogModule::TYPE_UPDATE);

        return $this->outputContent($result);
    }

    /**
     * 删除一个部门请求
     *
     * @return string
     */
    public function postDelete() {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required|numeric');
        $this->outputErrorIfExist();

        $department = DepartmentModule::getDepartmentById($id);
        $name = $department->name;

        $result = DepartmentModule::deleteDepartmentById($id);
        $this->outputErrorIfFail($result);

        $content ="删除部门:$name";
        LogModule::log($content, LogModule::TYPE_DEL);
        return $this->outputContent($result);
    }

    /**
     * 批量删除部门请求
     *
     * @return string
     */
    public function postDeleteBatch() {
        $this->outputUserNotLogin();

        $ids = $this->getParam('ids', 'required');
        $this->outputErrorIfExist();

        $ids = explode(',', $ids);
        if(count($ids) == 0) {
            $result = array('status' => false, 'msg' => 'error_must_choose_one');
            $this->outputErrorIfFail($result);
        }
        $result = DepartmentModule::deleteDepartmentsByIds($ids);
        $this->outputErrorIfFail($result);

        $content ="批量删除部门";
        LogModule::log($content, LogModule::TYPE_DEL);
        return $this->outputContent($result);
    }
}