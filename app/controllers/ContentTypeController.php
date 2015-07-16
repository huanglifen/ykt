<?php namespace App\Controllers;

use App\Module\ContentModule;
use App\Module\LogModule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Module\ContentTypeModule;

/**
 * 内容类型控制器
 *
 * @package App\Controllers
 */
class ContentTypeController extends  BaseController {
    public $langFile = 'content';
    /**
     * 显示首页
     *
     * @return \Illuminate\View\View
     */
    public function getIndex() {
        if(! $this->isLogin()) {
            return Redirect::to('/login');
        }
        return $this->showView('content.contentType');
    }

    /**
     * 获取内容类型
     * @return string
     */
    public function getContentType() {
        $this->outputUserNotLogin();

        $keyword = $this->getParam('keyword');
        $offset = $this->getParam('iDisplayStart');
        $limit = $this->getParam('iDisplayLength');

        $this->outputErrorIfExist();

        $contentType = ContentTypeModule::getContentTypes($keyword, $offset, $limit);
        $total = ContentTypeModule::countContentTypes($keyword);
        $result = array('contentType' => $contentType, 'iTotalDisplayRecords' => $total, '_iRecordsTotal' => $total, 'iDisplayStart' => $offset, 'iDisplayLength' => $limit);
        return json_encode($result);
    }

    /**
     * 显示新增页面
     *
     * @return \Illuminate\View\View
     */
    public function getAdd() {
        if(! $this->isLogin()) {
            return Redirect::to('/login');
        }
        return $this->showView('content.contentType-add');
    }

    /**
     * 新增内容类型请求
     *
     * @return string
     */
    public function postAdd() {
        $this->outputUserNotLogin();

        $number = $this->getParam('number', 'required|max:50');
        $name = $this->getParam('name', 'required|max:100');
        $sort = $this->getParam('sort', 'required|numeric');

        $this->outputErrorIfExist();

        $result = ContentTypeModule::addContentType($number, $name, $sort);
        $this->outputErrorIfFail($result);

        LogModule::log("新增内容类型:".$name, LogModule::TYPE_ADD);
        return $this->outputContent($result);
    }

    /**
     * 显示更新页面
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function getUpdate($id = 0) {
        if(! $this->isLogin()) {
            return Redirect::to('/login');
        }
        if(! $id) {
            return Redirect::to('/contentType/index');
        }
        $contentType = ContentTypeModule::getContentTypeById($id);
        if(empty($contentType)) {
            return Redirect::to('/contentType/index');
        }
        $this->data = compact('contentType');
        return $this->showView('content.conentType-update');
    }

    /**
     * 修改内容类型请求
     *
     * @return string
     */
    public function postUpdate() {
        $this->outputUserNotLogin();

        $number = $this->getParam('number', 'required|max:50');
        $name = $this->getParam('name', 'required|max:100');
        $sort = $this->getParam('sort', 'required|numeric');
        $id = $this->getParam('id', 'required|numeric');

        $this->outputErrorIfExist();

        $result = ContentTypeModule::updateContentType($id, $number, $name, $sort);
        $this->outputErrorIfFail($result);

        LogModule::log("修改内容类型:".$name, LogModule::TYPE_ADD);
        return $this->outputContent($result);
    }

    /**
     * 删除一个内容类型请求
     *
     * @return string
     */
    public function postDelete() {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required|numeric');
        $this->outputErrorIfExist();
        if($id == ContentModule::COMPANY_BRIEF) {
            $result = array('status' => false, 'msg' => 'error_id_cannot_delete');
            $this->outputErrorIfFail($result);
        }
        $result = ContentTypeModule::deleteContentType($id);
        $this->outputErrorIfFail($result);

        LogModule::log("删除内容类型:".$result['name'], LogModule::TYPE_DEL);
        return $this->outputContent($result);
    }

}