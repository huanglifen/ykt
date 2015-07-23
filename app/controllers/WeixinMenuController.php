<?php namespace App\Controllers;

use App\Module\ContentModule;
use App\Module\WeixinMenuModule;
use App\Module\WeixinSourceModule;
use Illuminate\Support\Facades\Redirect;

/**
 * 微信菜单控制器
 *
 * @package App\Controllers
 */
class WeixinMenuController extends BaseController {
    public $langFile = 'content';

    /**
     * 显示微信菜单列表页面
     *
     * @return \Illuminate\View\View
     */
    public function getIndex() {
        if(! $this->isLogin()) {
            return Redirect::to('/login');
        }
        $tree = WeixinMenuModule::getMenus();
        $json = json_encode(WeixinMenuModule::getJsonMenu($tree));

        $sources = ContentModule::getContent('', 0, 0, 0, 0, 0, ContentModule::CATEGORY_WEIXIN);
        $sources = ContentModule::formatWeixinSourceByType($sources);

        $this->data = compact('tree', 'json', 'sources');
        return $this->showView('content.weixinmenu');
    }

    public function postMenu() {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required|numeric');
        $parentId = $this->getParam('parentId', 'required|numeric');
        $name = $this->getParam('name', 'required|max:30');
        $category = $this->getParam('category');
        $type = $this->getParam('type');
        $key = $this->getParam('key');
        $url = $this->getParam('url');

        $this->outputErrorIfExist();

        $key  = $key ? $key : '';
        $url = $url ? $url : '';
        if($id) {
            $result = WeixinMenuModule::updateMenu($id, $parentId, $name, $category, $type, $key, $url, 1, 0, 0);
        } else {
            $result = WeixinMenuModule::addMenu($parentId, $name, $category, $type, $key, $url, 1, 0, 0);
        }
        $this->outputErrorIfFail($result);
        return $this->outputContent($result);
    }

    /**
     * 删除一个微信菜单请求
     *
     * @return string
     */
    public function postDelete() {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required|numeric');
        $this->outputErrorIfExist();

        $result = WeixinMenuModule::deleteMenu($id);
        $this->outputErrorIfFail($result);
        return $this->outputContent($result);
    }

    /**
     * 更新菜单到微信请求
     *
     * @return string
     */
    public function postSync() {
        $this->outputUserNotLogin();

        $result = WeixinMenuModule::syncMenu();
        $this->outputErrorIfFail($result);
        return $this->outputContent($result);
    }
}