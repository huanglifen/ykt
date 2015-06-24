<?php namespace App\Controllers;
use App\Module\LogModule;
use App\Module\UserModule;
use App\Module\RoleModule;
use App\Module\DepartmentModule;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

/**
 * 用户控制器
 *
 * @package App\Controllers
 */
class UserController extends  BaseController {
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

        return $this->showView('main.users');
    }

    /**
     * 按条件获取角色记录
     *
     * @return string
     */
    public function getUsers() {
        $this->outputUserNotLogin();

        $keyword = $this->getParam('keyword');
        $offset = $this->getParam('iDisplayStart');
        $limit = $this->getParam('iDisplayLength');
        $limit = $limit ? $limit : RoleModule::NUM_PER_PAGE;

        $this->outputErrorIfExist();

        $users = UserModule::getUsers($keyword, $offset, $limit);
        $total = UserModule::countUsers($keyword);
        $result = array('users' => $users, 'iTotalDisplayRecords' => $total, '_iRecordsTotal' => $total, 'iDisplayStart' => $offset, 'iDisplayLength' => $limit);

        return json_encode($result);
    }

    /**
     * 显示新增用户页面
     *
     * @return \Illuminate\View\View
     */
    public function getAdd() {
        $isLogin = $this->isLogin();
        if(! $isLogin){
            return \Redirect::to('/login');
        }

        $roles = RoleModule::getRolesByStatus();
        $departments = DepartmentModule::getDepartmentByStatus();

        $this->data = compact('roles', 'departments');
        return $this->showView('main.user-add');
    }

    /**
     * 新增用户请求
     *
     * @return string
     */
    public function postAdd() {
        $this->outputUserNotLogin();

        $name = htmlspecialchars($this->getParam('name', 'required'));
        $password = $this->getParam('password', 'required|min:6|max:50');
        $passwordConfirm = $this->getParam('passwordConfirm', 'required|min:6|max:50');
        $realName = htmlspecialchars($this->getParam('realName', 'required'));
        $roleId = $this->getParam('roleId', 'required');
        $departmentId = $this->getParam('departmentId');
        $tel = htmlspecialchars($this->getParam('tel', 'min:7|max:15'));
        $mail = $this->getParam('mail', 'email');
        $status = $this->getParam('status', 'required');

        if(!$roleId) {
            $this->errorInfo['roleId'] =\Lang::get($this->langFile . ".error_create_role_first") ;
        }
        if($password != $passwordConfirm) {
            $this->errorInfo['passwordConfirm'] = Lang::get($this->langFile .".error_passwordConfirm_should_equal_password");
        }

        $this->outputErrorIfExist();

        $result = UserModule::addUser($name, $password, $realName, $roleId, $departmentId, $tel, $mail, $status);

        $this->outputErrorIfFail($result);

        $content ="新增用户:$name";
        LogModule::log($content, LogModule::TYPE_ADD);

        return $this->outputContent($result['id']);
    }

    /**
     * 显示编辑用户
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getUpdate($id = 0) {
        $isLogin = $this->isLogin();
        if(! $isLogin){
            return \Redirect::to('/login');
        }

        if(! $id) {
            return \Redirect::to("user/index");
        }
        $user = UserModule::getUserById($id);
        if(empty($user)) {
            return \Redirect::to("user/index");
        }

        $roles = RoleModule::getRolesByStatus();
        $departments = DepartmentModule::getDepartmentByStatus();

        $this->data = compact('user', 'roles', 'departments');
        return $this->showView('main.user-update');
    }

    /**
     * 更新用户信息
     *
     * @return string
     */
    public function postUpdate() {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required|numeric');
        $realName = htmlspecialchars($this->getParam('realName', 'required'));
        $roleId = $this->getParam('roleId', 'required');
        $departmentId = $this->getParam('departmentId');
        $tel = htmlspecialchars($this->getParam('tel'));
        $mail = $this->getParam('mail');
        $status = $this->getParam('status');

        $this->outputErrorIfExist();

        $result = UserModule::updateUser($id, $realName, $roleId, $departmentId, $tel, $mail, $status);

        $this->outputErrorIfFail($result);

        $name = $result['name'];
        $content ="修改用户:$name";
        LogModule::log($content, LogModule::TYPE_UPDATE);

        return $this->outputContent($result['id']);
    }

    /**
     * 更新用户状态请求
     *
     * @return string
     */
    public function postStatus() {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required|numeric');

        $this->outputErrorIfExist();

        $result = UserModule::updateUserStatus($id);

        $this->outputErrorIfFail($result);

        $name = $result['name'];
        $content ="修改用户:$name 的状态";
        LogModule::log($content, LogModule::TYPE_UPDATE);

        return $this->outputContent($result);
    }

    /**
     * 删除一个用户请求
     *
     * @return string
     */
    public function postDelete() {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required|numeric');

        $this->outputErrorIfExist();

        $result = UserModule::deleteUserById($id);
        $this->outputErrorIfFail($result);

        $name = $result['name'];
        $content ="删除用户:$name";
        LogModule::log($content, LogModule::TYPE_DEL);

        return $this->outputContent($result);
    }

    /**
     * 批量删除用户请求
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

        $result = UserModule::deleteUserByIds($ids);
        $this->outputErrorIfFail($result);

        $content ="批量删除用户";
        LogModule::log($content, LogModule::TYPE_DEL);

        return $this->outputContent($result);
    }

    /**
     * 获取用户个人信息
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getInfo() {
        $isLogin = $this->isLogin();
        if(! $isLogin){
            return \Redirect::to('/login');
        }

        $roles = RoleModule::getRolesByStatus();
        $departments = DepartmentModule::getDepartmentByStatus();

        $userId = \Session::get('user_id');
        $user = UserModule::getUserById($userId);
        $this->data = compact('user', 'roles', 'departments');
        return $this->showView('login/userinfo');
    }

    /**
     * 显示修改密码页面
     *
     * @return \Illuminate\View\View
     */
    public function getPassword() {
        return $this->showView('login/password');
    }

    /**
     * 修改密码请求
     *
     * @return string
     */
    public function postPassword() {
        $this->outputUserNotLogin();

        $userId = \Session::get('user_id');
        $password = $this->getParam('password', 'required');
        $newpassword = $this->getParam('newpassword', 'required|min:6|max:50');
        $newpassword_confirmation = $this->getParam('newpassword_confirmation', 'required|min:6|max:50');

        if($newpassword != $newpassword_confirmation) {
            $this->errorInfo['passwordConfirm'] = Lang::get($this->langFile .".error_passwordConfirm_should_equal_password");
        }
        $this->outputErrorIfExist();

        $result = UserModule::updatePassword($userId, $password, $newpassword);
        $this->outputErrorIfFail($result);

        $content = "修改密码";
        LogModule::log($content, LogModule::TYPE_UPDATE);

        return $this->outputContent($result);
    }
}