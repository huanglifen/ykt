<?php namespace App\Controllers;

use App\Module\AreaModule;
use App\Module\BusinessDistrictModule;
use Illuminate\Support\Facades\Redirect;

/**
 * 商圈控制器
 *
 * @package App\Controllers
 */
class BusinessDistrictController extends  BaseController {
    public $langFile = "business";

    /**
     * 显示商圈首页
     *
     * @return \Illuminate\View\View
     */
    public function getIndex() {
        if(! $this->isLogin()) {
            return Redirect::to("/login");
        }

        $cities = AreaModule::getAreaByParentId();
        $districts = array();
        if(count($cities)) {
            $districts = AreaModule::getAreaByParentId($cities[0]->id);
        }

        $this->data = compact('cities', 'districts');
        return $this->showView('business.businessdistrict');
    }

    /**
     * 获取商圈记录请求
     *
     * @return string
     */
    public function getCircles() {
        $this->outputUserNotLogin();

        $cityId = $this->getParam('cityId');
        $districtId = $this->getParam('districtId');
        $keyword = $this->getParam('keyword');
        $offset = $this->getParam('iDisplayStart');
        $limit = $this->getParam('iDisplayLength');

        $this->outputErrorIfExist();
        if(! $cityId) {
            $cityId = AreaModule::CAPITAL;
        }
        if(! $districtId) {
            $districtId = 0;
        }
        $circles = BusinessDistrictModule::getCircle($keyword, $cityId, $districtId, $offset, $limit);
        $total = BusinessDistrictModule::countCircle($keyword, $cityId, $districtId);
        $result = array('circles' => $circles, 'iTotalDisplayRecords' => $total, '_iRecordsTotal' => $total, 'iDisplayStart' => $offset, 'iDisplayLength' => $limit);
        return json_encode($result);
    }

    /**
     * 显示新增商圈页面
     *
     * @return \Illuminate\View\View
     */
    public function getAdd() {
        if(! $this->isLogin()) {
            return Redirect::to("/login");
        }

        $cities = AreaModule::getAreaByParentId();
        $districts = array();
        if(! empty($cities)) {
            $districts = AreaModule::getAreaByParentId($cities[0]->id);
        }

        $this->data = compact('cities', 'districts');
        return $this->showView('business.businessdistrict-add');
    }

    /**
     * 新增商圈请求
     *
     * @return string
     */
    public function postAdd() {
        $this->outputUserNotLogin();

        $name = $this->getParam('name', 'required|max:80');
        $cityId = $this->getParam('cityId', 'required');
        $districtId = $this->getParam('districtId', 'required');
        $address = $this->getParam('address', 'required|max:150');
        $lat = $this->getParam('lat');
        $lng = $this->getParam('lng');
        $keyword = $this->getParam('keyword');

        $this->outputErrorIfExist();

        $result = BusinessDistrictModule::addCircle($name, $cityId, $districtId, $address, $lat, $lng, $keyword);
        return $this->outputContent($result);
    }

    public function getUpdate($id) {
        if(! $this->isLogin()) {
            return Redirect::to("/login");
        }
        $circle = BusinessDistrictModule::getCircleById($id);
        if(empty($circle)) {
            return Redirect::to("/circle/index");
        }
        $cityId = $circle->city_id;

        $cities = AreaModule::getAreaByParentId();
        $districts = AreaModule::getAreaByParentId($cityId);

        $this->data = compact('cities', 'districts', 'circle');
        return $this->showView('business.businessdistrict-update');
    }

    /**
     * 修改一个商圈请求
     *
     * @return string
     */
    public function postUpdate() {
        $this->outputUserNotLogin();

        $name = $this->getParam('name', 'required|max:80');
        $cityId = $this->getParam('cityId', 'required');
        $districtId = $this->getParam('districtId', 'required');
        $address = $this->getParam('address', 'required|max:150');
        $lat = $this->getParam('lat');
        $lng = $this->getParam('lng');
        $id = $this->getParam('id', 'required|numeric');
        $keyword = $this->getParam('keyword');

        $this->outputErrorIfExist();


        $result = BusinessDistrictModule::updateCircle($id, $name, $cityId, $districtId, $address, $lat, $lng, $keyword);
        $this->outputErrorIfFail($result);
        return $this->outputContent($result);
    }

    /**
     * 删除一个商圈请求
     *
     * @return string
     */
    public function postDelete() {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required|numeric');
        $this->outputErrorIfExist();

        $result = BusinessDistrictModule::deleteCircle($id);
        return $this->outputContent($result);
    }

    /**
     * 获取地区
     *
     * @param $cityId
     * @return string
     */
    public function getDistrict($cityId = 0) {
        $cityId = $cityId ? $cityId : AreaModule::CAPITAL;
        $result = AreaModule::getAreaByParentId($cityId);
        return $this->outputContent($result);
    }
}