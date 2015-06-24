<?php namespace App\Controllers;

use App\Module\LogModule;
use App\Module\MenuModule;
use App\Module\PermissionModule;
use App\Module\RoleModule;
use Illuminate\Support\Facades\Redirect;

/**
 * 角色控制器
 *
 * Class MenuController
 * @package App\Controllers
 */
class RoleController extends  BaseController {
    protected $langFile = 'previlege';

    /**
     * 显示角色页面
     *
     * @return \Illuminate\View\View
     */
    public function getIndex( ) {
        $isLogin = $this->isLogin();
        if(! $isLogin){
            return \Redirect::to('/login');
        }

        return $this->showView('main.roles');
    }

    /**
     * 按条件获取角色记录
     *
     * @return string
     */
    public function getRoles() {
        $this->outputUserNotLogin();

        $keyword = $this->getParam('keyword');
        $offset = $this->getParam('iDisplayStart');
        $limit = $this->getParam('iDisplayLength');
        $limit = $limit ? $limit : RoleModule::NUM_PER_PAGE;

        $this->outputErrorIfExist();

        $roles = RoleModule::getRoles($offset, $limit, $keyword);
        $total = RoleModule::countRoles($keyword);
        $result = array('roles' => $roles, 'iTotalDisplayRecords' => $total, '_iRecordsTotal' => $total, 'iDisplayStart' => $offset, 'iDisplayLength' => $limit);

        return json_encode($result);
    }

    /**
     * 显示新建角色页面
     *
     * @return \Illuminate\View\View
     */
    public function getAdd() {
        $isLogin = $this->isLogin();
        if(! $isLogin){
            return \Redirect::to('/login');
        }

      return $this->showView('main.role-add');
    }

    /**
     * 添加一个角色请求
     *
     * @return string
     */
    public function postAdd() {
        $this->outputUserNotLogin();

        $name = htmlspecialchars($this->getParam('name', 'required'));
        $description = htmlspecialchars($this->getParam('description'));
        $sort = $this->getParam('sort', 'required|numeric');
        $status = $this->getParam('status', 'required|numeric');

        $this->outputErrorIfExist();

        $result = RoleModule::addRole($name, $description, $sort, $status);

        $this->outputErrorIfFail($result);

        $content ="新增角色：$name";
        LogModule::log($content, LogModule::TYPE_ADD);
        return $this->outputContent($result['id']);
    }

    /**
     * 显示编辑角色页面
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
            return Redirect::to("role/index");
        }
        $role = RoleModule::getRoleById($id);
        if(empty($role)) {
            return Redirect::to("role/inidex");
        }
        $this->data['role'] = $role;
        return $this->showView("main.role-update");
    }

    /**
     * 编辑角色请求
     *
     * @return string
     */
    public function postUpdate() {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required|numeric');
        $name = htmlspecialchars($this->getParam('name', 'required'));
        $sort = $this->getParam('sort', 'required');
        $description = htmlspecialchars($this->getParam('description'));
        $status = $this->getParam('status', 'required');
        $this->outputErrorIfExist();

        $result = RoleModule::updateRoleById($id, $name, $sort, $description, $status);
        $this->outputErrorIfFail($result);

        $content ="修改角色：$name";
        LogModule::log($content, LogModule::TYPE_UPDATE);
        return $this->outputContent($result);
    }

    /**
     * 修改角色状态请求
     *
     * @return string
     */
    public function postStatus() {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required|numeric');
        $this->outputErrorIfExist();

        $result = RoleModule::updateRoleStatusById($id);

        $name = $result['name'];
        $content ="修改角色$name 的状态";
        LogModule::log($content, LogModule::TYPE_UPDATE);

        return $this->outputContent($result);
    }

    /**
     * 删除一个角色请求
     *
     * @return string
     */
    public function postDelete() {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required|numeric');
        $this->outputErrorIfExist();

        $result = RoleModule::deleteRoleById($id);
        $this->outputErrorIfFail($result);

        $content ="删除角色";
        LogModule::log($content, LogModule::TYPE_DEL);
        return $this->outputContent();
    }

    /**
     * 批量删除角色请求
     *
     * @return string
     */
    public function postDeleteBatch() {
        $ids = $this->getParam('ids', 'required');
        $this->outputErrorIfExist();

        $ids = explode(',', $ids);
        $result = RoleModule::deleteRolesbyIds($ids);
        $this->outputErrorIfFail($result);

        $content ="批量删除角色";
        LogModule::log($content, LogModule::TYPE_DEL);

        return $this->outputContent();
    }

    /**
     * 显示授权页面
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function getAuthority($id = 0) {
        $id = intval($id);
        if(! $id) {
            return Redirect::to("role/index");
        }
        $role = RoleModule::getRoleById($id);
        if(empty($role)) {
            return Redirect::to("role/inidex");
        }
        $menus = MenuModule::getAllDisplayMenus();
        $permissions = PermissionModule::getPermissionByRoleId($id);
        $this->data = compact("role", "menus", "permissions");
        return $this->showView('main.role-authority');
    }

    /**
     * 更新角色的操作权限
     *
     * @return string
     */
    public function postAuthority() {
        $id = $this->getParam('id', 'required|numeric');
        $ids = $this->getParam('ids', 'required');
        $this->outputErrorIfExist();

        $ids = explode(',', $ids);
        $result = PermissionModule::addPermissionByRole($id, $ids);

        $role = RoleModule::getRoleById($id);
        $name = $role->name;
        $content ="更新角色$name 的权限";
        LogModule::log($content, LogModule::TYPE_DEL);

        return $this->outputContent($result);
    }
}