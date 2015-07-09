<?php namespace App\Controllers;

use App\Module\IndustryModule;
use Illuminate\Support\Facades\Redirect;

/**
 * 行业控制器
 *
 * @package App\Controllers
 */
class IndustryController extends BaseController {

    public $langFile = 'business';

    /**
     * 显示行业页面
     *
     * @return \Illuminate\View\View
     */
    public function getIndex() {
        if(! $this->isLogin()) {
            return Redirect::to("/login");
        }
        $parents = IndustryModule::getIndustries('', 0, 0, -1);
        $this->data = compact('parents');
        return $this->showView('business.industry');
    }

    /**
     * 按条件获取行业记录请求
     *
     * @return string
     */
    public function getIndustries() {
        $this->outputUserNotLogin();

        $parentId = $this->getParam('parentId');
        $keyword = $this->getParam('keyword');
        $offset = $this->getParam('iDisplayStart');
        $limit = $this->getParam('iDisplayLength');

        $this->outputErrorIfExist();

        if($parentId === null) {
            $parentId = -1;
        }
        $industries = IndustryModule::getIndustries($keyword, $parentId, $offset, $limit);
        $total = IndustryModule::countIndustries($keyword, $parentId);
        $result = array('industry' => $industries, 'iTotalDisplayRecords' => $total, '_iRecordsTotal' => $total, 'iDisplayStart' => $offset, 'iDisplayLength' => $limit);

        return json_encode($result);
    }

    /**
     * 显示新建页面
     *
     * @return \Illuminate\View\View
     */
    public function getAdd() {
        if(! $this->isLogin()) {
            return Redirect::to("/login");
        }
        $parents = IndustryModule::getIndustries('', 0, 0, -1);
        $this->data = compact('parents');
        return $this->showView('business.industry-add');
    }

    /**
     * 新增行业请求
     *
     * @return string
     */
    public function postAdd() {
        $this->outputUserNotLogin();

        $name = $this->getParam('name', 'required|max:100');
        $parentId = $this->getParam('parentId', 'required|numeric');

        $this->outputErrorIfExist();

        $result = IndustryModule::addIndustry($name, $parentId);
        $this->outputErrorIfFail($result);
        return $this->outputContent($result);
    }

    /**
     * 显示更新页面
     *
     * @param int $id
     * @return mixed
     */
    public function getUpdate($id = 0) {
        if(! $this->isLogin()) {
            return Redirect::to("/login");
        }
        $industry = IndustryModule::getIndustryById($id);
        if(empty($industry)) {
            return Redirect::to("/industry");
        }
        $parents = IndustryModule::getIndustries('', 0, 0, -1);
        $hasChild = IndustryModule::checkChild($id);
        $this->data = compact('industry', 'parents', 'hasChild');
        return $this->showView('business.industry-update');
    }

    /**
     * 更新一个行业请求
     *
     * @return string
     */
    public function postUpdate() {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required|numeric');
        $name = $this->getParam('name', 'required|max:50');
        $parentId = $this->getParam('parentId', 'numeric');

        $this->outputErrorIfExist();

        $result = IndustryModule::updateIndustryById($id, $name, $parentId);
        $this->outputErrorIfFail($result);

        return $this->outputContent($result);
    }

    /**
     * 删除一个行业请求
     *
     * @return string
     */
    public function postDelete() {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required|numeric');
        $this->outputErrorIfExist();

        $result = IndustryModule::deleteIndustry($id);
        $this->outputErrorIfFail($result);

        return $this->outputContent($result);
    }
}