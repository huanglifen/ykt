<?php namespace App\Controllers;

use App\Module\ContentModule;
use App\Module\LogModule;
use Illuminate\Support\Facades\Lang;

/**
 * 新闻控制器
 *
 * @package App\Controllers
 */
class NewsController extends  BaseController {
    public $langFile = 'content';
    public $newsType = array(
        '1' => '首页',
        '2' => 'ETC页',
        '3' => '旅游通页'
    );

    /**
     * 显示新闻页面
     *
     * @return \Illuminate\View\View
     */
    public function getIndex() {
        if(! $this->isLogin()) {
            return Redirect::to('/login');
        }
        $contentType = $this->newsType;
        $this->data = compact('contentType');
        return $this->showView('content.news');
    }

    /**
     * 获取新闻内容请求
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

        $content = ContentModule::getContent($title, $type, $startTime, $endTime, $offset, $limit, ContentModule::CATEGORY_NEWS);
        $total = ContentModule::countContent($title, $type, $startTime, $endTime, ContentModule::CATEGORY_NEWS);
        $result = array('content' => $content, 'iTotalDisplayRecords' => $total, '_iRecordsTotal' => $total, 'iDisplayStart' => $offset, 'iDisplayLength' => $limit);
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
        $contentType = $this->newsType;
        $this->data = compact('contentType');
        return $this->showView('content.news-add');
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
        $context = $this->getParam('editor', 'required');
        $display = $this->getParam('display', 'required|numeric');
        $source = $this->getParam('source', 'max:100');
        $author = $this->getParam('author', 'max:100');
        $startTime = strtotime($this->getParam('startTime'));
        $endTime = strtotime($this->getParam('endTime'));
        $category = ContentModule::CATEGORY_NEWS;
        if($startTime && $endTime && $startTime >= $endTime) {
            $this->errorInfo['endTime'] = \Lang::get($this->langFile . '.error_endTime_cannot_less_than_startTime');
        }
        $this->outputErrorIfExist();

        $result = ContentModule::addContent($title, '', $context, $display, $source, $author, $type, $startTime, $endTime, 0, $category);
        $this->outputErrorIfFail($result);

        LogModule::log("新增新闻：" . $title, LogModule::TYPE_ADD);
        return $this->outputContent($result);
    }

    /**
     * 显示更新页面
     *
     * @param $id
     * @return \Illuminate\View\View
     */
    public function getUpdate($id = 0) {
        if(! $this->isLogin()) {
            return Redirect::to('/login');
        }
        if(! $id) {
            return Redirect::to("/news/index");
        }
        $content = ContentModule::getContentById($id);
        if(empty($content)) {
            return Redirect::to("/news/index");
        }
        $contentType = $this->newsType;
        $this->data = compact('contentType', 'content', 'id');
        return $this->showView('content.news-update');

    }

    /**
     * 更新内容请求
     *
     * @return string
     */
    public function postUpdate() {
        $this->outputUserNotLogin();

        $type = $this->getParam('type', 'required|numeric');
        $title = $this->getParam('title', 'required|max:150');
        $context = $this->getParam('editor', 'required');
        $display = $this->getParam('display', 'required|numeric');
        $source = $this->getParam('source', 'max:100');
        $author = $this->getParam('author', 'max:100');
        $id = $this->getParam('id', 'required|numeric');
        $startTime = strtotime($this->getParam('startTime'));
        $endTime = strtotime($this->getParam('endTime'));

        if($startTime && $endTime && $startTime >= $endTime) {
            $this->errorInfo['endTime'] = \Lang::get($this->langFile . '.error_endTime_cannot_less_than_startTime');
        }

        $this->outputErrorIfExist();

        $category = ContentModule::CATEGORY_NEWS;
        $result = ContentModule::updateContent($id, $title, '', $context, $display, $source, $author, $type, $startTime, $endTime, $category);
        $this->outputErrorIfFail($result);

        LogModule::log("修改新闻：" . $title, LogModule::TYPE_UPDATE);
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

        $news = ContentModule::getContentById($id);
        $result = ContentModule::deleteContent($id);
        $this->outputErrorIfFail($result);

        LogModule::log("删除新闻：" . $news->title, LogModule::TYPE_DEL);
        return $this->outputContent($result);
    }
}