<?php namespace App\Controllers;
use App\Module\BaseModule;
use App\Module\LogModule;
use App\Module\UserModule;

/**
 * 日志控制器
 *
 * @package App\Controllers
 */
class LogController extends  BaseController {
    protected $langFile = 'login';

    /**
     * 显示日志页面
     *
     * @return \Illuminate\View\View
     */
    public function getIndex( ) {
        $isLogin = $this->isLogin();
        if(! $isLogin){
            return \Redirect::to('/login');
        }

        $users = UserModule::getUsers('', 0, 500);
        $this->data = compact('users');
        return $this->showView('login.logs');
    }

    /**
     * 获取日志记录
     *
     * @return string
     */
    public function getLogs() {
        $this->outputUserNotLogin();

        $userId = $this->getParam('userId');
        $begin = $this->getParam('beginTime');
        $end = $this->getParam('endTime');
        $offset = $this->getParam('iDisplayStart');
        $limit = $this->getParam('iDisplayLength');
        $limit = $limit ? $limit : BaseModule::NUM_PER_PAGE;
        $limit = $limit > 20 ? 20 : $limit;

        $this->outputErrorIfExist();
        if($begin) {
            $begin = date("Y-m-d H:i:s", strtotime($begin));
        }
        if($end) {
            $end = date("Y-m-d H:i:s", strtotime($end));
        }

        $logs = LogModule::getLogs($userId, $begin, $end, $offset, $limit);
        $total = LogModule::countLogs($userId, $begin, $end);
        $result = array('logs' => $logs, 'iTotalDisplayRecords' => $total, '_iRecordsTotal' => $total, 'iDisplayStart' => $offset, 'iDisplayLength' => $limit);

        return json_encode($result);
    }
}