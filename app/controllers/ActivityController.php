<?php namespace App\Controllers;
use App\Module\ActivityModule;
use App\Module\BusinessModule;
use App\Module\LogModule;

/**
 * 活动控制器
 *
 * @package App\Controllers
 */
class ActivityController extends  BaseController {
    public $langFile = "business";

    /**
     * 活动首页
     *
     * @param $businessId
     * @return \Illuminate\View\View
     */
    public function getIndex($businessId = 0) {
        if(! $this->isLogin()) {
            return Redirect::to('/login');
        }
        if(! $businessId) {
            return \Redirect::to('/business/index');
        }

        $business = BusinessModule::getBusinessById($businessId);
        if(empty($business)) {
            return \Redirect::to('/business/index');
        }

        $this->data = compact('business', 'businessId');
        return $this->showView('business.activity');
    }

    /**
     * 按商户主键获取活动列表
     *
     * @param $businessId
     * @return string
     */
    public function getActivity($businessId) {
        $this->outputUserNotLogin();

        $keyword = $this->getParam('keyword');
        $offset = $this->getParam('iDisplayStart');
        $limit = $this->getParam('iDisplayLength');

        $this->outputErrorIfExist();

        $activity = ActivityModule::getActivity($businessId, $keyword, $offset, $limit);
        $total = ActivityModule::countActivity($businessId, $keyword);
        $result = array('activity' => $activity, 'iTotalDisplayRecords' => $total, '_iRecordsTotal' => $total, 'iDisplayStart' => $offset, 'iDisplayLength' => $limit);
        return json_encode($result);
    }

    /**
     * 显示新增活动页面
     *
     * @param int $businessId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getAdd($businessId = 0) {
        if(! $this->isLogin()) {
            return Redirect::to('/login');
        }
        if(! $businessId) {
            return \Redirect::to('/business/index');
        }

        $business = BusinessModule::getBusinessById($businessId);
        if(empty($business)) {
            return \Redirect::to('/business/index');
        }

        $this->data = compact('business', 'businessId');
        return $this->showView('business.activity-add');
    }

    /**
     * 增加一个活动请求
     *
     * @return string
     */
    public function postAdd() {
        $this->outputUserNotLogin();

        $businessId = $this->getParam('businessId', 'required');
        $title = $this->getParam('title', 'required|max:100');
        $startTime = strtotime($this->getParam('startTime', 'required'));
        $endTime = strtotime($this->getParam('endTime', 'required'));
        $content = $this->getParam('content', 'required|max:1000');
        $status = $this->getParam('status', 'required');
        if($endTime <= $startTime) {
            $this->errorInfo['endTime'] = \Lang::get($this->langFile .'.error_endTime_must_greater_than_startTime');
        }

        $this->outputErrorIfExist();

        $result = ActivityModule::addActivity($businessId, $title, $startTime, $endTime, $content, $status);
        $this->outputErrorIfFail($result);

        LogModule::log("增加活动：" . $title, LogModule::TYPE_ADD);
        return $this->outputContent($result);
    }

    /**
     * 显示更新活动请求
     *
     * @param $businessId
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getUpdate($businessId = 0, $id = 0) {
        if(! $this->isLogin()) {
            return Redirect::to('/login');
        }
        if(! $businessId) {
            return \Redirect::to('/business/index');
        }

        $business = BusinessModule::getBusinessById($businessId);
        if(empty($business)) {
            return \Redirect::to('/business/index');
        }

        $activity = ActivityModule::getActivityById($id);

        $this->data = compact('business', 'activity', 'businessId', 'id');
        return $this->showView('business.activity-update');
    }

    /**
     * 修改一个活动请求
     *
     * @return string
     */
    public function postUpdate() {
        $this->outputUserNotLogin();

        $businessId = $this->getParam('businessId', 'required');
        $title = $this->getParam('title', 'required|max:100');
        $startTime = strtotime($this->getParam('startTime', 'required'));
        $endTime = strtotime($this->getParam('endTime', 'required'));
        $content = $this->getParam('content', 'required|max:1000');
        $status = $this->getParam('status', 'required');
        $id = $this->getParam('id', 'required|numeric');
        if($endTime <= $startTime) {
            $this->errorInfo['endTime'] = \Lang::get($this->langFile .'.error_endTime_must_greater_than_startTime');
        }

        $this->outputErrorIfExist();

        $result = ActivityModule::updateActivity($id, $businessId, $title, $startTime, $endTime, $content, $status);
        $this->outputErrorIfFail($result);

        LogModule::log("更新活动：" . $title, LogModule::TYPE_UPDATE);
        return $this->outputContent($result);
    }

    /**
     * 删除活动请求
     *
     * @return string
     */
    public function postDelete() {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required|numeric');

        $this->outputErrorIfExist();

        $activity = ActivityModule::getActivityById($id);
        $result = ActivityModule::deleteActivity($id);
        $this->outputErrorIfFail($result);

        LogModule::log("删除活动：" . $activity->title, LogModule::TYPE_DEL);
        return $this->outputContent($result);
    }
}