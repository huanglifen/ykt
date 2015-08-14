<?php namespace App\Controllers;

use App\Module\ContentModule;
use App\Module\ContentTypeModule;
use App\Module\LogModule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

/**
 * 帮助控制器
 *
 * @package App\Controllers
 */
class HelpController extends  BaseController {
    public $langFile = 'content';

    /**
     * 显示帮助页面
     *
     * @param $type
     *
     * @return \Illuminate\View\View
     */
    public function getIndex($type = 0) {
        if(! $this->isLogin()) {
            return Redirect::to('/login');
        }
        if($type) {
            $contentType = array();
        }else{
            $contentType = ContentTypeModule::getContentTypes('', -1);
        }
        $this->data = compact('type', 'contentType');
        return $this->showView('content.help');
    }

    /**
     * 获取帮助内容请求
     *
     * @return string
     */
    public function getContent( ) {
        $this->outputUserNotLogin();

        $title = $this->getParam('title');
        $startTime = $this->getParam('startTime');
        $endTime = $this->getParam('endTime');
        $offset = $this->getParam('iDisplayStart');
        $limit = $this->getParam('iDisplayLength');
        $type = $this->getParam('type');

        $this->outputErrorIfExist();

        $title = $title ? $title : '';
        $startTime = $startTime ? strtotime($startTime): 0;
        $endTime = $endTime ? strtotime($endTime) : 0;
        $limit = $limit ? $limit : -1;

        $content = ContentModule::getContent($title, $type, $startTime, $endTime, $offset, $limit);
        $total = ContentModule::countContent($title, $type, $startTime, $endTime);
        $result = array('content' => $content, 'iTotalDisplayRecords' => $total, '_iRecordsTotal' => $total, 'iDisplayStart' => $offset, 'iDisplayLength' => $limit);
        return json_encode($result);

    }

    /**
     * 显示新增页面
     *
     * @param int $type
     * @return \Illuminate\View\View
     */
    public function getAdd($type = 0) {
        if(! $this->isLogin()) {
            return Redirect::to('/login');
        }
        if($type) {
            $contentType = array();
        }else{
            $contentType = ContentTypeModule::getContentTypes('', -1);
        }
        $this->data = compact('type', 'contentType');
        return $this->showView('content.help-add');
    }

    /**
     * 新增内容请求
     *
     * @return string
     */
    public function postAdd() {
        $this->outputUserNotLogin();

        $type = $this->getParam('type', 'required|numeric');
        $title = $this->getParam('title', 'required|max:150');
        $brief = $this->getParam('brief', 'required|max:500');
        $context = $this->getParam('editor', 'required');
        $display = $this->getParam('display', 'required|numeric');
        $source = $this->getParam('source', 'max:100');
        $sort = $this->getParam('sort', 'numeric|between:1,99');
        $author = $this->getParam('author', 'max:100');
        $startTime = strtotime($this->getParam('startTime'));
        $endTime = strtotime($this->getParam('endTime'));

        if($startTime && $endTime && $startTime >= $endTime) {
            $this->errorInfo['endTime'] = \Lang::get($this->langFile . '.error_endTime_cannot_less_than_startTime');
        }
        $this->outputErrorIfExist();

        $category = ContentModule::CATEGORY_HELP;
        $result = ContentModule::addContent($title, $brief, $context, $display, $source, $author, $type, $startTime, $endTime, $sort, $category);
        $this->outputErrorIfFail($result);

        LogModule::log("新增帮助内容：$title", LogModule::TYPE_ADD);
        return $this->outputContent($result);
    }

    /**
     * 显示更新页面
     *
     * @param $id
     * @param $type
     * @return \Illuminate\View\View
     */
    public function getUpdate($id = 0, $type = 0) {
        if(! $this->isLogin()) {
            return Redirect::to('/login');
        }
        if(! $id) {
            return Redirect::to("/help/index".$type);
        }
        $help = ContentModule::getContentById($id);
        if(empty($help)) {
            return Redirect::to("/help/index".$type);
        }
        $contentType = ContentTypeModule::getContentTypes('', -1);
        $this->data = compact('contentType', 'type', 'help', 'id');
        return $this->showView('content.help-update');

    }

    public function postUpdate() {
        $this->outputUserNotLogin();

        $type = $this->getParam('type', 'required|numeric');
        $title = $this->getParam('title', 'required|max:150');
        $brief = $this->getParam('brief', 'required|max:500');
        $context = $this->getParam('editor', 'required');
        $display = $this->getParam('display', 'required|numeric');
        $source = $this->getParam('source', 'max:100');
        $sort = $this->getParam('sort', 'numeric|between:1,99');
        $author = $this->getParam('author', 'max:100');
        $id = $this->getParam('id', 'required|numeric');
        $startTime = strtotime($this->getParam('startTime'));
        $endTime = strtotime($this->getParam('endTime'));

        if($startTime && $endTime && $startTime >= $endTime) {
            $this->errorInfo['endTime'] = \Lang::get($this->langFile . '.error_endTime_cannot_less_than_startTime');
        }

        $this->outputErrorIfExist();

        $category = ContentModule::CATEGORY_HELP;
        $result = ContentModule::updateContent($id, $title, $brief, $context, $display, $source, $author, $type, $startTime, $endTime, $sort, $category);
        $this->outputErrorIfFail($result);

        LogModule::log("修改帮助内容：$title", LogModule::TYPE_UPDATE);
        return $this->outputContent($result);
    }

    /**
     * 删除一个内容请求
     *
     * @return string
     */
    public function postDelete() {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required|numeric');

        $this->outputErrorIfExist();

        $help = ContentModule::getContentById($id);
        $result = ContentModule::deleteContent($id);
        $this->outputErrorIfFail($result);

        LogModule::log("删除帮助内容：" . $help->title, LogModule::TYPE_DEL);
        return $this->outputContent($result);
    }
}