<?php namespace App\Controllers;

use App\Module\AreaModule;
use App\Module\CustomerServiceModule;
use App\Module\LogModule;

/**
 * 客服控制器
 *
 * @package App\Controllers
 */
class CustomerServiceController extends BaseController {

    public $langFile = 'setting';

    /**
     * 显示客服页面
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getIndex() {
        if(! $this->isLogin()) {
            return \Redirect::to('/login');
        }
        return $this->showView('setting.customer-service');
    }

    /**
     * 获取客服记录
     *
     * @return string
     */
    public function getCs(){
        $this->outputUserNotLogin();

        $name = $this->getParam('name');
        $offset = $this->getParam('iDisplayStart');
        $limit = $this->getParam('iDisplayLength');

        $this->outputErrorIfExist();

        $cs = CustomerServiceModule::getCustomerServices($name, $offset, $limit);
        $total = CustomerServiceModule::countCustomerServices($name);
        $result = array('cs' => $cs, 'iTotalDisplayRecords' => $total, '_iRecordsTotal' => $total, 'iDisplayStart' => $offset, 'iDisplayLength' => $limit);
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
        $city = AreaModule::getAreaByParentId();
        $this->data = compact('city');
        return $this->showView('setting.customer-service-add');
    }

    /**
     * 新增客服请求
     *
     * @return string
     */
    public function postAdd() {
        $this->outputUserNotLogin();

        $name = $this->getParam('name', 'required|max:100');
        $qq = $this->getParam('qq', 'required|max:15');
        $cityId = $this->getParam('cityId', 'required|numeric');
        $display = $this->getParam('display', 'required|numeric');

        $this->outputUserNotLogin();
        $result = CustomerServiceModule::addCustomerService($name, $qq, $cityId, $display);
        $this->outputErrorIfFail($result);

        LogModule::log("新增客服：" . $name, LogModule::TYPE_ADD);
        return $this->outputContent($result);
    }

    /**
     * 显示新增页面
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getUpdate($id = 0) {
        if(! $this->isLogin()) {
            return \Redirect::to('/login');
        }
        if(! $id) {
            return \Redirect::to('/cs/index');
        }
        $cs = CustomerServiceModule::getCustomerServiceById($id);
        $city = AreaModule::getAreaByParentId();;
        $this->data = compact('cs', 'city', 'id');
        return $this->showView('setting.customer-service-update');
    }

    /**
     * 更新客服请求
     *
     * @return string
     */
    public function postUpdate() {
        $this->outputUserNotLogin();

        $name = $this->getParam('name', 'required|max:100');
        $qq = $this->getParam('qq', 'required|max:15');
        $cityId = $this->getParam('cityId', 'required|numeric');
        $display = $this->getParam('display', 'required|numeric');
        $id = $this->getParam('id', 'required|numeric');

        $this->outputErrorIfExist();

        $result = CustomerServiceModule::updateCustomerService($id, $name, $qq, $cityId, $display);
        $this->outputErrorIfFail($result);

        LogModule::log("修改客服：" . $name, LogModule::TYPE_UPDATE);
        return $this->outputContent($result);
    }

    /**
     * 删除一个客服请求
     *
     * @return string
     */
    public function postDelete() {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required|numeric');
        $this->outputErrorIfExist();

        $cs = CustomerServiceModule::getCustomerServiceById($id);
        $result = CustomerServiceModule::deleteCustomerService($id);
        $this->outputErrorIfFail($result);

        LogModule::log("删除客服：" . $cs->name, LogModule::TYPE_DEL);
        return $this->outputContent($result);
    }
}