<?php namespace App\Controllers;

use App\Module\LogModule;
use App\Module\PartnerModule;

/**
 * 合作伙伴控制器
 *
 * @package App\Controllers
 */
class PartnerController extends BaseController {
    public $langFile = "setting";

    /**
     * 显示页面
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getIndex( ) {
        if(! $this->isLogin()) {
            return \Redirect::to('/login');
        }
        return $this->showView('setting.partner');
    }

    /**
     * 获取合作伙伴请求
     *
     * @return string
     */
    public function getPartner() {
        $this->outputUserNotLogin();

        $offset = $this->getParam('iDisplayStart');
        $limit = $this->getParam('iDisplayLength');

        $this->outputErrorIfExist();

        $partners = PartnerModule::getPartners($offset, $limit);
        $total = PartnerModule::countPartners();
        $result = array('partners' => $partners, 'iTotalDisplayRecords' => $total, '_iRecordsTotal' => $total, 'iDisplayStart' => $offset, 'iDisplayLength' => $limit);
        return json_encode($result);
    }

    /**
     * 显示新增页面
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getAdd() {
        if(! $this->isLogin()) {
            return \Redirect::to('/login');
        }
        return $this->showView('setting.partner-add');
    }

    /**
     * 新增合作伙伴请求
     *
     * @return string
     */
    public function postAdd() {
        $this->outputUserNotLogin();

        $name = $this->getParam('name', 'required');
        $picture = $this->getParam('picture');
        $sort = $this->getParam('sort', 'numeric|max:99|min:0');
        $display = $this->getParam('display');

        $this->outputErrorIfExist();

        $result = PartnerModule::addPartner($name, $picture, $sort, $display);
        $this->outputErrorIfFail($result);

        LogModule::log("新增合作伙伴" . $name, LogModule::TYPE_ADD);
        return $this->outputContent($result);
    }

    /**
     * 显示更新页面
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getUpdate($id = 0) {
        if(! $this->isLogin()) {
            return \Redirect::to('/login');
        }
        if(! $id) {
            return \Redirect::to('/partner/index');
        }
        $partner = PartnerModule::getPartnerById($id);
        if(empty($partner)) {
            return \Redirect::to('/partner/index');
        }
        $this->data = compact('partner', 'id');
        return $this->showView('setting.partner-update');
    }

    /**
     * 更新一个合作伙伴
     *
     * @return string
     */
    public function postUpdate() {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required|numeric');
        $name = $this->getParam('name', 'required');
        $picture = $this->getParam('picture');
        $sort = $this->getParam('sort', 'between:0,99');
        $display = $this->getParam('display');

        $this->outputErrorIfExist();

        $result = PartnerModule::updatePartner($id, $name, $picture, $sort, $display);
        $this->outputErrorIfFail($result);

        LogModule::log("更新合作伙伴" . $name, LogModule::TYPE_UPDATE);
        return $this->outputContent($result);
    }

    /**
     * 删除一个合作伙伴
     *
     * @return string
     */
    public function postDelete() {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required|numeric');
        $this->outputErrorIfExist();

        $partner = PartnerModule::getPartnerById($id);
        $result = PartnerModule::deletePartner($id);
        $this->outputErrorIfFail($result);

        LogModule::log("删除合作伙伴" . $partner->name, LogModule::TYPE_DEL);
        return $this->outputContent($result);
    }
}