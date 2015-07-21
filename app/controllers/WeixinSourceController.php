<?php namespace App\Controllers;
use Illuminate\Support\Facades\Redirect;
use App\Module\ContentModule;

/**
 * 微信素材控制器
 *
 * @package App\Controllers
 */
class WeixinSourceController extends BaseController {

    public $langFile = 'content';

    public $viewArr = array(
        ContentModule::TYPE_SINGLE => 'single',
        ContentModule::TYPE_MULTI => 'multi',
        ContentModule::TYPE_CUSTOM => 'custom'
    );
    /**
     * 显示微信页面
     *
     * @return \Illuminate\View\View
     */
    public function getIndex() {
        if(! $this->isLogin()) {
            return Redirect::to('/login');
        }
        return $this->showView('content.weixinsource');
    }

    /**
     * 显示微信素材列表
     *
     * @return string
     */
    public function getSources() {
        $this->outputUserNotLogin();

        $title = $this->getParam('title');
        $type = $this->getParam('type');
        $offset = $this->getParam('iDisplayStart');
        $limit = $this->getParam('iDisplayLength');

        $this->outputErrorIfExist();

        $contents = ContentModule::getContent($title, $type, 0, 0, $offset, $limit, ContentModule::CATEGORY_WEIXIN);
        $total = ContentModule::countContent($title, $type, 0, 0, ContentModule::CATEGORY_WEIXIN);
        $result = array('contents' => $contents, 'iTotalDisplayRecords' => $total, '_iRecordsTotal' => $total, 'iDisplayStart' => $offset, 'iDisplayLength' => $limit);
        return json_encode($result);
    }

    /**
     * 显示增加图文页面
     *
     * @param int $type
     * @return \Illuminate\View\View
     */
    public function getAdd($type = ContentModule::TYPE_CUSTOM) {
        if(! $this->isLogin()) {
            return Redirect::to('/login');
        }
        $view = $this->viewArr[$type];
        $this->data = compact('type');
        return $this->showView('content.weixinsource-' . $view . "-add");
    }

    /**
     * 增加图文请求
     *
     * @return string
     */
    public function postAdd() {
        $this->outputUserNotLogin();

        $type = $this->getParam('type', 'required|numeric');
        $title = $this->getParam('title', 'required|max:150');
        $brief = $this->getParam('brief', 'max:500');
        $context = $this->getParam('editor');
        $cover = $this->getParam('cover', '');
        $url = $this->getParam('url');

        $parentId = 0;
        if($type == ContentModule::TYPE_MULTI) {
            $parentId = $this->getParam('parentId', 'required');
        }
        $this->outputErrorIfExist();

        $category = ContentModule::CATEGORY_WEIXIN;
        $brief = $brief ? $brief : '';
        $cover = $cover ? $cover : '';
        $url = $url ? $url : '';
        $result = ContentModule::addContent($title, $brief, $context, 1, '', '', $type, 0, 0, 0, $category, $parentId, $url, $cover);
        $this->outputErrorIfFail($result);

        return $this->outputContent($result);
    }

    public function getUpdate($id = 0) {
        if(! $this->isLogin()) {
            return Redirect::to('/login');
        }
        if(! $id) {
            return Redirect::to("/wsource/index");
        }
        $source = ContentModule::getContentById($id);
        if(empty($source)) {
            return Redirect::to("/wsource/index");
        }
        if($source->type == ContentModule::TYPE_MULTI) {
            $source = ContentModule::getMultiSourceById($id);
        }
        $type = $source->type;
        if(! in_array($type, array(ContentModule::TYPE_CUSTOM, ContentModule::TYPE_SINGLE, ContentModule::TYPE_MULTI))) {
            $type = ContentModule::TYPE_CUSTOM;
        }

        $this->data = compact('source', 'id', 'type');
        $view = $this->viewArr[$source->type];
        return $this->showView('content.weixinsource-' . $view . "-update");
    }

    /**
     * 更新一个素材请求
     *
     * @return string
     */
    public function postUpdate() {
        $this->outputUserNotLogin();

        $type = $this->getParam('type', 'required|numeric');
        $title = $this->getParam('title', 'required|max:150');
        $brief = $this->getParam('brief', 'max:500');
        $context = $this->getParam('editor');
        $cover = $this->getParam('cover');
        $url = $this->getParam('url');
        $id = $this->getParam('id', 'required');

        $parentId = 0;
        if($type == ContentModule::TYPE_MULTI) {
            $parentId = $this->getParam('parentId', 'required');
        }
        $this->outputErrorIfExist();

        $category = ContentModule::CATEGORY_WEIXIN;
        $result = ContentModule::updateContent($id, $title, $brief, $context, 1, '', '', $type, 0, 0, $category, $parentId, $url, $cover);
        $this->outputErrorIfFail($result);

        return $this->outputContent($result);
    }

    /**
     * 删除一个微信素材请求
     *
     * @return string
     */
    public function postDelete() {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required|numeric');
        $type = $this->getParam('parentId');
        $this->outputErrorIfExist();

        $result = ContentModule::deleteWeixinSource($id, $type);
        $this->outputErrorIfFail($result);
        return $this->outputContent($result);
    }

}