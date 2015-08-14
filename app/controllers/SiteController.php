<?php namespace App\Controllers;
use App\Module\AreaModule;
use App\Module\LogModule;
use App\Module\SiteModule;
use Illuminate\Support\Facades\Redirect;

/**
 * 网点控制器
 *
 * @package App\Controllers
 */
class SiteController extends  BaseController {
    public $langFile = "setting";

    public $typeArr = array(
        SiteModule::TYPE_DIRECT => '直营网点',
        SiteModule::TYPE_Agent => '代理网点',
        SiteModule::TYPE_Cooperate => '合作网点'
    );

    /**
     * 显示网点列表页面
     *
     * @return \Illuminate\View\View
     */
    public function getIndex() {
        if(! $this->isLogin()) {
            return Redirect::to("/login");
        }
        $typeArr = $this->typeArr;
        $this->data = compact('typeArr');
        return $this->showView('setting.site');
    }

    /**
     * 按条件获取网点记录请求
     *
     * @return string
     */
    public function getSite() {
        $this->outputUserNotLogin();

        $type = $this->getParam('type');
        $name = $this->getParam('name');
        $contact = $this->getParam('contact');
        $tel = $this->getParam('tel');
        $offset = $this->getParam('iDisplayStart');
        $limit = $this->getParam('iDisplayLength');

        $this->outputErrorIfExist();

        $site = SiteModule::getSites($type, $name, $contact, $tel, $offset, $limit);
        $total = SiteModule::countSites($type, $name, $contact, $tel);
        $result = array('site' => $site, 'iTotalDisplayRecords' => $total, '_iRecordsTotal' => $total, 'iDisplayStart' => $offset, 'iDisplayLength' => $limit);
        return json_encode($result);
    }

    /**
     * 显示新增页面
     *
     * @return \Illuminate\View\View
     */
    public function getAdd() {
        if (!$this->isLogin()) {
            return Redirect::to("/login");
        }

        $typeArr = $this->typeArr;

        $cities = AreaModule::getAreaByParentId();
        $districts = array();
        if(! empty($cities)) {
            $districts = AreaModule::getAreaByParentId($cities[0]->id);
        }
        $this->data = compact('typeArr', 'cities', 'districts');
        return $this->showView('setting.site-add');
    }

    /**
     * 新增网点请求
     *
     * @return string
     */
    public function postAdd() {
        $this->outputUserNotLogin();

        $type = $this->getParam('type', 'required');
        $name = $this->getParam('name', 'required|max:100');
        $number = $this->getParam('number', 'required|max:50');
        $contact = $this->getParam('contact', 'max:100');
        $address = $this->getParam('address', 'max:100');
        $areaId = $this->getParam('districtId', 'required');
        $picture = $this->getParam('picture', 'max:100');
        $remark = $this->getParam('remark', 'max:150');
        $tel = $this->getParam('tel');

        $startTime = strtotime($this->getParam('startTime'));
        $endTime = strtotime($this->getParam('endTime'));
        if($startTime && $endTime && $startTime >= $endTime) {
            $this->errorInfo['endTime'] = \Lang::get($this->langFile . '.error_endTime_cannot_less_than_startTime');
        }

        $this->outputErrorIfExist();

        $result = SiteModule::addSite($type, $number, $name, $contact, $address, $areaId, $startTime, $endTime, $tel, $picture, $remark);
        $this->outputErrorIfFail($result);

        LogModule::log("新增网点" . $name, LogModule::TYPE_ADD);
        return $this->outputContent($result);
    }

    /**
     * 显示更新页面
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function getUpdate($id = 0) {
        if (!$this->isLogin()) {
            return Redirect::to("/login");
        }
        if(! $id) {
            return Redirect::to('/site/index');
        }
        $site = SiteModule::getSiteById($id);
        if(empty($site)) {
            return Redirect::to('/site/index');
        }

        $typeArr = $this->typeArr;
        $cities = AreaModule::getAreaByParentId();
        $districts = array();
        $parentId = AreaModule::CAPITAL;
        if ($site->area_id) {
            $parentId = substr($site->area_id, 0, 4);
            $districts = AreaModule::getAreaByParentId($parentId);
        } elseif (!empty($cities)) {
            $districts = AreaModule::getAreaByParentId($cities[0]->id);
        }
        $this->data = compact('typeArr', 'site', 'id', 'cities', 'districts', 'parentId');
        return $this->showView('setting.site-update');
    }

    /**
     * 更新一个网点请求
     *
     * @return string
     */
    public function postUpdate() {
        $this->outputUserNotLogin();

        $type = $this->getParam('type', 'required');
        $name = $this->getParam('name', 'required|max:100');
        $number = $this->getParam('number', 'required|max:50');
        $contact = $this->getParam('contact', 'max:100');
        $address = $this->getParam('address', 'max:100');
        $areaId = $this->getParam('districtId', 'required');
        $tel = $this->getParam('tel', 'max:30');
        $picture = $this->getParam('picture', 'max:100');
        $remark = $this->getParam('remark', 'max:150');
        $id = $this->getParam('id', 'required');

        $startTime = strtotime($this->getParam('startTime'));
        $endTime = strtotime($this->getParam('endTime'));
        if($startTime && $endTime && $startTime >= $endTime) {
            $this->errorInfo['endTime'] = \Lang::get($this->langFile . '.error_endTime_cannot_less_than_startTime');
        }

        $this->outputErrorIfExist();

        $result = SiteModule::updateSite($id, $type, $number, $name, $contact, $address, $areaId, $startTime, $endTime, $tel, $picture, $remark);
        $this->outputErrorIfFail($result);

        LogModule::log("更新网点" . $name, LogModule::TYPE_UPDATE);
        return $this->outputContent($result);
    }

    /**
     * 删除一个网点请求
     *
     * @return string
     */
    public function postDelete() {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required');
        $this->outputErrorIfExist();

        $site = SiteModule::getSiteById($id);
        $result = SiteModule::deleteSite($id);
        $this->outputErrorIfFail($result);

        LogModule::log("删除网点：" . $site->name, LogModule::TYPE_DEL);
        return $this->outputContent($result);
    }
}