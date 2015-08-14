<?php namespace App\Controllers;

use App\Model\WeixinMenu;
use App\Module\ContentModule;
use App\Module\LogModule;
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
        if($id) {
            LogModule::log("修改微信菜单：" . $name, LogModule::TYPE_UPDATE);
        }else{
            LogModule::log("新增微信菜单：" . $name, LogModule::TYPE_ADD);
        }
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

        $menu = WeixinMenuModule::getMenuById($id);
        $result = WeixinMenuModule::deleteMenu($id);
        $this->outputErrorIfFail($result);

        LogModule::log("删除微信菜单：" . $menu->name, LogModule::TYPE_DEL);
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

        LogModule::log("更新微信菜单到微信平台" , LogModule::TYPE_UPDATE);
        return $this->outputContent($result);
    }
}