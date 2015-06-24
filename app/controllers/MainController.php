<?php namespace App\Controllers;

use App\Module\LogModule;
use App\Module\UserModule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

/**
 * 主页面控制器
 *
 * @package App\Controllers
 */
class MainController extends BaseController {
    protected $langFile = 'previlege';

    /**
     * 显示登录页面
     *
     * @return \Illuminate\View\View
     */
    public function getLogIn() {
       return $this->showView("main.login");
    }

    /**
     * 登录请求
     *
     * @return string
     */
    public function postLogIn() {
        $name = $this->getParam('name', 'required');
        $password = $this->getParam('password', 'required');

        $this->outputErrorIfExist();

        $result = UserModule::checkUser($name, $password);

        $this->outputErrorIfFail($result);


        Session::put("user_id", $result['user']->id);
        Session::put("user_name", $result['user']->name);
        Session::put("last_time", $result['last_time']);

        $content ="登录";
        LogModule::log($content);

        return $this->outputContent($result['status']);
    }

    /**
     * 注销
     *
     * @return mixed
     */
    public function getLogOut() {
        Session::forget("user_id");
        Session::forget("user_name");
        Session::forget("last_time");
        return Redirect::to("login");
    }

    /**
     * 显示主页面
     *
     * @return \Illuminate\View\View
     */
    public function getIndex() {
        $isLogin = $this->isLogin();
        if(! $isLogin){
            return \Redirect::to('/login');
        }

        $userId = Session::get("user_id");
        $userName = Session::get("user_name");
        $lastTime = Session::get("last_time");

        $global_menus = $this->getGlobalMenus($userId);

        $this->data = compact('userName', 'lastTime', 'userId', 'global_menus');

        return $this->showView("common.main");
    }

    /**
     * 显示欢迎页面
     *
     * @return \Illuminate\View\View
     */
    public function getWelcome() {
        $isLogin = $this->isLogin();
        if(! $isLogin){
            return \Redirect::to('/login');
        }
        return $this->showView("main.welcome");
    }
}
