<?php namespace App\Controllers;

use App\Module\LogModule;
use App\Module\MenuModule;
use Illuminate\Support\Facades\Redirect;

/**
 * 菜单控制器
 *
 * Class MenuController
 * @package App\Controllers
 */
class MenuController extends  BaseController {
    protected $langFile = 'previlege';

    /**
     * 显示菜单页面
     *
     * @return \Illuminate\View\View
     */
    public function getIndex( ) {
        $isLogin = $this->isLogin();
        if(! $isLogin){
            return \Redirect::to('/login');
        }

        return $this->showView('main.menus');
    }

    /**
     * 按条件获取菜单记录
     *
     * @return string
     */
    public function getMenus() {
        $this->outputUserNotLogin();

        $keyword = $this->getParam('keyword');
        $offset = $this->getParam('iDisplayStart');
        $limit = $this->getParam('iDisplayLength');
        $limit = $limit ? $limit : MenuModule::NUM_PER_PAGE;

        $this->outputErrorIfExist();

        $menus = MenuModule::getMenus($offset, $limit, $keyword);
        $total = MenuModule::countMenus($keyword);
        $result = array('menus' => $menus, 'iTotalDisplayRecords' => $total, '_iRecordsTotal' => $total, 'iDisplayStart' => $offset, 'iDisplayLength' => $limit);

        return json_encode($result);
    }

    /**
     * 显示新建菜单页面
     *
     * @return \Illuminate\View\View
     */
    public function getAdd( ) {
        $isLogin = $this->isLogin();
        if(! $isLogin){
            return \Redirect::to('/login');
        }

        $menus = MenuModule::getSuperMenu();
        $this->data = compact('menus');
        return $this->showView('main.menu-add');
    }

    /**
     * 保存一个菜单
     *
     * @return string
     */
    public function postAdd( ) {
        $this->outputUserNotLogin();

        $name = htmlspecialchars($this->getParam('name', 'required'));
        $parent = $this->getParam('parent', 'required');
        $url = htmlspecialchars($this->getParam('url'));
        $sort = $this->getParam('sort', 'required|numeric');
        $display = $this->getParam('display', 'required|numeric');

        $this->outputErrorIfExist();

        $result = MenuModule::addMenu($name, $parent, $url, $sort, $display);

        $this->outputErrorIfFail($result);

        $content ="新增菜单：$name";
        LogModule::log($content, LogModule::TYPE_ADD);
        return $this->outputContent($result['id']);
    }

    /**
     * 显示修改菜单页面
     *
     * @return \Illuminate\View\View
     */
    public function getUpdate($id = 0) {
        $isLogin = $this->isLogin();
        if(! $isLogin){
            return \Redirect::to('/login');
        }

        $id = intval($id);
        if(! $id) {
            return Redirect::to('menu/index');
        }
        $menu = MenuModule::getMenuAndParentNameById($id);
        if(empty($menu)) {
            return Redirect::to('menu/index');
        }
        $menus = MenuModule::getSuperMenu();
        $this->data = compact('menus', 'menu');
        return $this->showView('main.menu-update');
    }

    /**
     * 修改一个菜单
     *
     * @return string
     */
    public function postUpdate( ) {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required');
        $name = htmlspecialchars($this->getParam('name', 'required'));
        $url = htmlspecialchars($this->getParam('url'));
        $sort = $this->getParam('sort', 'required|numeric');
        $display = $this->getParam('display', 'required|numeric');

        $this->outputErrorIfExist();

        $result = MenuModule::updateMenu($id, $name, $url, $sort, $display);

        $this->outputErrorIfFail($result);

        $content ="修改菜单：$name";
        LogModule::log($content, LogModule::TYPE_UPDATE);
        return $this->outputContent($result['id']);
    }

    /**
     * 删除一个菜单
     *
     * @return string
     */
    public function postDelete( ) {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required');
        $this->outputErrorIfExist();

        $result = MenuModule::deleteMenu($id);
        $this->outputErrorIfFail($result);

        $name = $result['name'];
        $content ="删除菜单：$name";
        LogModule::log($content, LogModule::TYPE_DEL);
        return $this->outputContent($result);
    }

    /**
     * 批量删除菜单
     *
     * @return string]
     */
    public function postDeleteBatch() {
        $this->outputUserNotLogin();

        $deleteArr = $this->getParam('deleteArr', 'required');
        $this->outputErrorIfExist();

        $deleteArr = json_decode($deleteArr, true);
        $result = MenuModule::deleteMenus($deleteArr);
        $this->outputErrorIfFail($result);

        $content ="批量删除菜单";
        LogModule::log($content, LogModule::TYPE_DEL);
        return $this->outputContent($result);
    }
}