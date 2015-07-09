<?php namespace App\Controllers;
use App\Module\BusinessDistrictModule;
use App\Module\BusinessModule;
use App\Module\CardTypeModule;
use App\Module\IndustryModule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Module\AreaModule;

/**
 * 商户控制器
 *
 * @package App\Controllers
 */
class BusinessController extends  BaseController {
    public $langFile = "business";

    /**
     * 商户首页
     *
     * @return \Illuminate\View\View
     */
    public function getIndex() {
        if(! $this->isLogin()) {
            return Redirect::to('/login');
        }
        $cities = AreaModule::getAreaByParentId();

        $districts = array();
        if(count($cities) != 0) {
            $districts = AreaModule::getAreaByParentId($cities[0]->id);
        }

        $this->data = compact('cities', 'districts');
        return $this->showView('business.business');
    }

    public function getBusiness() {
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
        $business = BusinessModule::getBusiness($keyword, $cityId, $districtId, $offset, $limit);
        $business = BusinessModule::getBusinessIndustry($business);
        $total = BusinessModule::countBusiness($keyword, $cityId, $districtId);
        $result = array('business' => $business, 'iTotalDisplayRecords' => $total, '_iRecordsTotal' => $total, 'iDisplayStart' => $offset, 'iDisplayLength' => $limit);
        return json_encode($result);
    }

    /**
     * 新增商户页面
     *
     * @return \Illuminate\View\View
     */
    public function getAdd() {
        if(! $this->isLogin()) {
            return Redirect::to('/login');
        }
        $cities = AreaModule::getAreaByParentId();

        $districts = array();
        if(count($cities) != 0) {
            $districts = AreaModule::getAreaByParentId($cities[0]->id);
        }
        $circles = BusinessDistrictModule::getCircle();
        $cardType = CardTypeModule::getCardType(0, -1);
        $industry = IndustryModule::getIndustries('', -1);

        $this->data = compact('cities', 'districts', 'circles', 'cardType', 'industry');
        return $this->showView('business.business-add');
    }

    /**
     * 新增一个商户请求
     *
     * @return string
     */
    public function postAdd() {
        $this->outputUserNotLogin();
        $data = array();
        $data = $this->commonBusiness($data);
        $data['password'] = $this->getParam('password', 'required|max:100');
        $this->outputErrorIfExist();
        $result = BusinessModule::addBusiness($data);
        return $this->outputContent($result);
    }

    /**
     * 显示更新页面
     *
     * @param $id
     * @return \Illuminate\View\View
     */
    public function getUpdate($id) {
        if(! $this->isLogin()) {
            return Redirect::to('/login');
        }
        if(! $id) {
            return Redirect::to('/business/index');
        }
        $business = BusinessModule::getBusinessById($id);
        if(empty($business)) {
            return Redirect::to('/business/index');
        }
        $business->card_type = explode(',', $business->card_type);
        $business->industry = explode(',', $business->industry);

        $cityId = $business->city_id;
        $cities = AreaModule::getAreaByParentId();
        $districts = AreaModule::getAreaByParentId($cityId);

        $circles = BusinessDistrictModule::getCircle();
        $cardType = CardTypeModule::getCardType(0, -1);
        $industry = IndustryModule::getIndustries('', -1);

        $this->data = compact('cities', 'districts', 'circles', 'cardType', 'industry', 'business');
        return $this->showView('business.business-update');
    }

    /**
     * 更新商户请求
     *
     * @return string
     */
    public function postUpdate() {
        $this->outputUserNotLogin();
        $data = array();
        $data = $this->commonBusiness($data);
        $data['id'] = $this->getParam('id', 'numeric');
        $data['password'] = $this->getParam('password', 'max:100');

        $this->outputErrorIfExist();

        $result = BusinessModule::updateBusiness($data);
        return $this->outputContent($result);
    }

    /**
     * 删除商户请求
     *
     * @return string
     */
    public function postDelete() {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required|numeric');
        $this->outputErrorIfExist();
        $result = BusinessModule::deleteBusinessById($id);
        $this->outputErrorIfFail($result);
        return $this->outputContent($result);
    }

    /**
     * 新增，修改商户请求公共部分
     *
     * @param $data
     * @return mixed
     */
    private function commonBusiness($data) {
        $data['cityId'] = $this->getParam('cityId', 'required');
        $data['districtId'] = $this->getParam('districtId', 'required');
        $data['name'] = $this->getParam('name', 'required|max:30');
        $data['account'] = $this->getParam('account', 'required|max:100');
        $data['number'] = $this->getParam('number', 'required|max:50');
        $data['integralNumber'] = $this->getParam('integralNumber', 'max:50');
        $data['address'] = $this->getParam('address', 'max:100');
        $data['circle'] = $this->getParam('circle', 'numeric');
        $data['bankType'] = $this->getParam('bankType', 'max:50');
        $data['bankAccount'] = $this->getParam('bankAccount', 'max:50');
        $data['tariff'] = $this->getParam('tariff', 'max:50');
        $data['license'] = $this->getParam('license', 'max:50');
        $data['contacter'] = $this->getParam('contacter', 'max:50');
        $data['email'] = $this->getParam('email', 'max:50');
        $data['phone'] = $this->getParam('phone', 'max:20');
        $data['tel'] = $this->getParam('tel', 'max:20');
        $data['qq'] = $this->getParam('qq', 'max:12');
        $data['cardType'] = $this->getParam('cardType', 'max:50');
        $data['industry'] = $this->getParam('industry', 'max:50');
        $data['discount'] = $this->getParam('discount', 'numeric|between:0,10');
        $data['star'] = $this->getParam('star', 'numeric');
        $data['status'] = $this->getParam('status');
        $data['level'] = $this->getParam('level');
        $data['picture'] = $this->getParam('picture', 'max:100');
        $data['promotion'] = $this->getParam('promotion', 'max:100');
        $data['description'] = $this->getParam('description');
        $data['appDescription'] = $this->getParam('appDescription');
        $data['lng'] = $this->getParam('lng', 'max:10');
        $data['lat'] = $this->getParam('lat', 'max:10');
        $data['uniqueNumber'] = $this->getParam('uniqueNumber', 'max:10');
        return $data;
    }
}
