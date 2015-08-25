<?php namespace App\Controllers;

use App\Module\BusinessModule;
use App\Module\BusinessTypeModule;

/**
 * 商户促销类型控制器层
 *
 * @package App\Controllers
 */
class BusinessTypeController extends BaseController {
    protected $langFile = "content";
    /**
     * 显示商户促销页面
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getIndex() {
        if(! $this->isLogin()) {
            return \Redirect::to("/login");
        }
        return $this->showView('business.businesstype');
    }

    /**
     * 按条件获取商户促销类型
     *
     * @return string
     */
    public function getBusinessTypes() {
        $this->outputUserNotLogin();

        $name = $this->getParam('name');
        $offset = $this->getParam('iDisplayStart');
        $limit = $this->getParam('iDisplayLength');

        $this->outputErrorIfExist();

        $businessTypes = BusinessTypeModule::getBusinessTypes($name, $offset, $limit);
        $total = BusinessTypeModule::countBusinessTypes($name);
        $result = array('businessTypes' => $businessTypes, 'iTotalDisplayRecords' => $total, '_iRecordsTotal' => $total, 'iDisplayStart' => $offset, 'iDisplayLength' => $limit);
        return json_encode($result);
    }

    /**
     * 显示新增商户类型页面
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getAdd() {
        if(! $this->isLogin()) {
            return \Redirect::to("/login");
        }
        return $this->showView('business.businesstype-add');
    }

    /**
     * 添加商户促销类型请求
     *
     * @return string
     */
    public function postAdd() {
        $this->outputUserNotLogin();

        $name = $this->getParam('name', 'required');
        $status = $this->getParam('status', 'required');
        $sort = $this->getParam('sort', 'required|between:1,99');
        $this->outputErrorIfExist();

        $result = BusinessTypeModule::addBusinessType($name, $status, $sort);
        $this->outputErrorIfFail($result);
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
            return \Redirect::to("/login");
        }
        if(! $id) {
            return \Redirect::to("business-type/index");
        }
        $businessType = BusinessTypeModule::getBusinessTypeById($id);
        $this->data = compact('businessType', 'id');
        return $this->showView('business.businesstype-update');
    }

    /**
     * 更新一个商户促销请求
     *
     * @return string
     */
    public function postUpdate() {
        $this->outputUserNotLogin();

        $name = $this->getParam('name', 'required');
        $status = $this->getParam('status', 'required');
        $sort = $this->getParam('sort', 'required|between:1,99');
        $id = $this->getParam('id', 'required|numeric');
        $this->outputErrorIfExist();

        $result = BusinessTypeModule::updateBusinessType($id, $name, $status, $sort);
        $this->outputErrorIfFail($result);
        return $this->outputContent($result);
    }

    /**
     * 删除一个商户促销类型请求
     *
     * @return string
     */
    public function postDelete() {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required|numeric');
        $this->outputErrorIfExist();

        $result = BusinessTypeModule::deleteBusinessType($id);
        $this->outputErrorIfFail($result);
        return $this->outputContent($result);
    }
}