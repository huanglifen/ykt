<?php namespace App\Module;

use App\Model\WeixinMenu;

/**
 * 微信菜单module层
 *
 * @package App\Module
 */
class WeixinMenuModule extends BaseModule {
    const LEVEL_ONE = 3; //一级菜单至多3个
    const LEVEL_TWO = 5; //每个一级菜单下二级菜单至多5个

    /**
     * 新增一个菜单
     *
     * @param $parentId
     * @param $name
     * @param $category
     * @param $type
     * @param $key
     * @param $url
     * @param $isShow
     * @param $isDel
     * @param int $orderNo
     * @return array
     */
    public static function addMenu($parentId, $name, $category, $type, $key, $url, $isShow, $isDel, $orderNo = 0) {
        $menu = new WeixinMenu();
        $menu->parent_id = $parentId;
        $menu->name = $name;
        $menu->category = $category;
        $menu->type = $type;
        $menu->key = $key;
        $menu->url = $url;
        $menu->is_show = $isShow;
        $menu->is_del = $isDel;
        $menu->order_no = $orderNo;

        $menu->save();
        return array('status' => true, 'id' => $menu->id);
    }

    /**
     * 删除一个菜单
     *
     * @param $id
     * @return array
     */
    public static function deleteMenu($id) {
        $menu = WeixinMenu::find($id);
        if(empty($menu)) {
            return array('status' => false, 'msg' => 'error_id_not_exist');
        }
        WeixinMenu::destroy($id);
        return array('status' => true);
    }

    /**
     * 更新一个菜单
     *
     * @param $id
     * @param $parentId
     * @param $name
     * @param $category
     * @param $type
     * @param $key
     * @param $url
     * @param $isShow
     * @param $isDel
     * @param int $orderNo
     * @return array
     */
    public static function updateMenu($id, $parentId, $name, $category, $type, $key, $url, $isShow, $isDel, $orderNo = 0) {
        $menu = WeixinMenu::find($id);
        if(empty($menu)) {
            return array('status' => false, 'msg' => 'error_id_not_exist');
        }
        $menu->parent_id = $parentId;
        $menu->name = $name;
        $menu->category = $category;
        $menu->type = $type;
        $menu->key = $key;
        $menu->url = $url;
        $menu->is_show = $isShow;
        $menu->is_del = $isDel;
        $menu->order_no = $orderNo;

        $menu->update();
        return array('status' => true, 'id' => $menu->id);
    }

    /**
     * 获取菜单列表
     *
     * @return array
     */
    public static function getMenus() {
        $menu = new WeixinMenu();
        $menu = $menu->orderBy("order_no", "ASC")->get();
        $menu = self::getTree($menu);
        return $menu;
    }

    /**
     * 按树的格式获取菜单记录
     *
     * @param $menus
     * @return array
     */
    protected static function getTree($menus) {
        $tree = array();
        $node = array();
        foreach($menus as $m) {
            if($m->parent_id == 0) {
                $tree[$m->id] = $m;
            }else{
                $node[] = $m;
            }
        }
        foreach($node as $n) {
            if(isset($tree[$n->parent_id])) {
                $menu = &$tree[$n->parent_id];
                $menu->children[] = $n;
            }
        }
        return $tree;
    }
}