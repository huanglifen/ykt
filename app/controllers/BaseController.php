<?php namespace App\Controllers;

use App\Module\MenuModule;
use App\Module\PermissionModule;
use App\Module\RoleModule;
use App\Module\UserModule;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

/**
 * 基类控制器
 *
 * @package App\Controllers
 */
class BaseController extends Controller {

    public $errorInfo = array();
    public $msgCode = array(
        1001 => 'error_old_password'
    );
    protected $langFile = 'common';

    const RESPONSE_OK = 0;
    const RESPONSE_FAIL = 1000;
    const RESPONSE_CHECK_FAIL = 1001; //数据验证失败
    const RESPONSE_USER_NOT_LOGIN = 2001;
    const RESPONSE_AUTHORITY_DENY = 1003; //权限不够

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

    /**
     * 解析状态码，输出响应失败信息
     *
     * @param $result
     */
    protected function outputErrorIfFail($result) {
        if (! $result['status']) {
            $msg = $result['msg'];
            if(is_array($msg)) {
                foreach ($msg as $key => $value) {
                    if (array_key_exists($value, $this->msgCode)) {
                        $msg[$key] = Lang::get($this->langFile . "." . $this->msgCode[$value]);
                    }
                }
            }else{
                $msg = Lang::get($this->langFile . "." . $msg);
            }
            $result = $this->output(self::RESPONSE_FAIL, $msg);;
            echo $result;
            exit;
        }
    }

    /**
     * 响应参数验证失败
     */
    protected function outputErrorIfExist()
    {
        if ($this->errorInfo) {
            $result = $this->output(self::RESPONSE_CHECK_FAIL, $this->errorInfo);
            echo $result;
            exit;
        }
    }

    /**
     * 用户未登录
     */
    protected function outputUserNotLogin()
    {
        $login = $this->isLogin();
        if(! $login) {
            $result = $this->output(self::RESPONSE_USER_NOT_LOGIN, '用户未登录');
            echo $result;
        }
    }

    protected function outputContent($result = '')
    {
        return $this->output(self::RESPONSE_OK, $result);
    }

    protected function output($status, $result = '')
    {
        return json_encode(array('status' => $status, 'result' => $result));
    }

    /**
     * 接收参数，并对参数进行有效性验证
     *
     * @param $param
     * @param $ruleString
     * @return mixed
     */
    protected function getParam($param, $ruleString = '')
    {
        $paramValue = Input::get($param);

        if (!empty($ruleString)) {
            $ruleArr = explode('|', $ruleString);
            $rules = array();
            $messages = array();

            foreach ($ruleArr as $ruleStr) {
                if (preg_match("/(.*?)(\\{(.*)\\})$/U", $ruleStr, $match)) {
                    $rule = $match[1];
                    $message = $match[3] ? $match[3] : '';
                    $rules[] = $rule;

                    if (preg_match("/(.*?)\:(.*)/", $rule, $matchMsg)) {
                        $rule = $matchMsg[1];
                    }

                    if ($message) {
                        $messages[$rule] = $message;
                    }
                }else{
                    $rules[] = $ruleStr;
                }
            }

            $input = array($param => $paramValue);
            $rules = array($param => $rules);

            $validate = Validator::make($input, $rules, $messages);

            if ($validate->fails()) {
                $msg = $validate->messages()->first($param);
                $this->errorInfo[$param] = Lang::get($this->langFile . "." . $msg);
            }
        }
        return $paramValue;
    }

    /**
     * 显示视图
     *
     * @param $view
     * @return \Illuminate\View\View
     */
    protected function showView($view) {
        $baseURL = \URL::to('/');

        $this->data['baseURL'] = $baseURL;
        $this->data['jsURL'] = $baseURL . "/asset/js/";
        $this->data['cssURL'] = $baseURL . "/asset/css/";
        $this->data['imgURL'] = $baseURL . "/asset/image/";
        $this->data['mediaURL'] = $baseURL . "/media/";

        return \View::make($view, $this->data);
    }

    /**
     * 获取主页面菜单
     *
     * @param $userId
     * @return array
     */
    protected function getGlobalMenus($userId) {
        $user = UserModule::getUserById($userId);
        if($user->status == UserModule::STATUS_ADMIN) {
            $menus = MenuModule::getAllDisplayMenus();
        }else{
            $role = RoleModule::getRoleById($user->role_id);
            $menuIds = PermissionModule::getPermissionByRoleId($role->id);
            $menus =  MenuModule::getMenuByIds($menuIds);
        }

        return array('menus' => $menus);
    }

    /**
     * 判断用户是否登录
     *
     * @return bool
     */
    protected function isLogin() {
        if(\Session::has('user_id')) {
            return true;
        }
        return false;
    }
}
