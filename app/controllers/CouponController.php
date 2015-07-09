<?php namespace App\Controllers;
use App\Module\AreaModule;
use App\Module\BusinessDistrictModule;
use App\Module\BusinessModule;
use App\Module\CouponModule;

/**
 * 优惠券控制器
 *
 * @package App\Controllers
 */
class CouponController extends  BaseController {
    public $langFile = "business";

    /**
     * 优惠券首页
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
        return $this->showView('business.coupon');
    }

    /**
     * 按商户主键获取优惠券列表
     *
     * @param $businessId
     * @return string
     */
    public function getCoupon($businessId) {
        $this->outputUserNotLogin();

        $keyword = $this->getParam('keyword');
        $offset = $this->getParam('iDisplayStart');
        $limit = $this->getParam('iDisplayLength');

        $this->outputErrorIfExist();

        $coupon = CouponModule::getCoupon($businessId, $keyword, $offset, $limit);
        $total = CouponModule::countCoupon($businessId, $keyword);
        $result = array('coupon' => $coupon, 'iTotalDisplayRecords' => $total, '_iRecordsTotal' => $total, 'iDisplayStart' => $offset, 'iDisplayLength' => $limit);
        return json_encode($result);
    }

    /**
     * 显示新增优惠券页面
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
        $cities = AreaModule::getAreaByParentId();

        $this->data = compact('business', 'businessId', 'cities');
        return $this->showView('business.coupon-add');
    }

    /**
     * 增加一个优惠券请求
     *
     * @return string
     */
    public function postAdd() {
        $this->outputUserNotLogin();

        $businessId = $this->getParam('businessId', 'required');
        $title = $this->getParam('title', 'required|max:100');
        $picture = $this->getParam('picture','required|max:100');
        $amount = $this->getParam('amount', 'required|numeric');
        $remainAmount = $this->getParam('remainAmount', 'required|numeric');
        $startTime = strtotime($this->getParam('startTime', 'required'));
        $endTime = strtotime($this->getParam('endTime', 'required'));
        $content = $this->getParam('content', 'required|max:1000');
        $status = $this->getParam('status', 'required');
        $cityId = $this->getParam('cityId', 'required|numeric');
        if($endTime && $endTime <= $startTime) {
            $this->errorInfo['endTime'] = \Lang::get($this->langFile .'.error_endTime_must_greater_than_startTime');
        }

        $this->outputErrorIfExist();

        $result = CouponModule::addCoupon($businessId, $title, $picture, $amount, $remainAmount, $cityId, $startTime, $endTime, $content, $status);
        $this->outputErrorIfFail($result);
        return $this->outputContent($result);
    }

    /**
     * 显示更新优惠券请求
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

        $coupon = CouponModule::getCouponById($id);
        $cities = AreaModule::getAreaByParentId();

        $this->data = compact('business', 'coupon', 'businessId', 'id', 'cities');
        return $this->showView('business.coupon-update');
    }

    /**
     * 修改一个优惠券请求
     *
     * @return string
     */
    public function postUpdate() {
        $this->outputUserNotLogin();

        $businessId = $this->getParam('businessId', 'required');
        $title = $this->getParam('title', 'required|max:100');
        $picture = $this->getParam('picture','required|max:100');
        $amount = $this->getParam('amount', 'required|numeric');
        $remainAmount = $this->getParam('remainAmount', 'required|numeric');
        $startTime = strtotime($this->getParam('startTime', 'required'));
        $endTime = strtotime($this->getParam('endTime', 'required'));
        $content = $this->getParam('content', 'required|max:1000');
        $status = $this->getParam('status', 'required');
        $cityId = $this->getParam('cityId', 'required|numeric');
        $id = $this->getParam('id', 'required|numeric');
        if($endTime <= $startTime) {
            $this->errorInfo['endTime'] = \Lang::get($this->langFile .'.error_endTime_must_greater_than_startTime');
        }

        $this->outputErrorIfExist();

        $result = CouponModule::updateCoupon($id, $businessId, $title, $picture, $amount, $remainAmount, $cityId, $startTime, $endTime, $content, $status);
        $this->outputErrorIfFail($result);
        return $this->outputContent($result);
    }

    /**
     * 删除优惠券请求
     *
     * @return string
     */
    public function postDelete() {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required|numeric');

        $this->outputErrorIfExist();

        $result = CouponModule::deleteCoupon($id);
        $this->outputErrorIfFail($result);
        return $this->outputContent($result);
    }
}