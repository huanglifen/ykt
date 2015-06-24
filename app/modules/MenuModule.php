<?php  namespace App\Module;

use App\Model\Menu;

/**
 * 菜单module层
 *
 * Class MenuModule
 * @package App\Module
 */
class MenuModule extends BaseModule{
    const DEFAULT_PARENT  = 0;
    const MENU_SHOW = 1;
    const MENU_HIDE = 2;
    const MAX_CHILD = 999; //最多子菜单数
    const MENU_CLASS = 3;

    /**
     * 添加一个菜单
     *
     * @param $name
     * @param int $parentId
     * @param string $url
     * @param int $sort
     * @param int $display
     * @return array
     */
    public static function addMenu($name, $parentId = self::DEFAULT_PARENT, $url = '', $sort = 0, $display = self::MENU_SHOW) {
        $parent = self::getParent($parentId);
        $number = self::generateMenuNumber($parentId, $parent->number);
        if(! $number) {
            return array('status' => false, 'msg' => 'error_create_fail');
        }
        $menu = new Menu();
        $menu->name = $name;
        $menu->number = $number;
        $menu->group = $parent->group ? $parent->group : $number;
        $menu->level = $parent->level + 1;
        $menu->parent_id = $parentId;
        $menu->url = $url;
        $menu->sort = $sort;
        $menu->display = $display;
        $menu->save();

        return array('status' => true, 'id' => $menu->id);
    }

    /**
     * 删除一个或者多个菜单
     *
     * @param array $deleteArr
     * @return int
     */
    public static function deleteMenus(array $deleteArr) {
        $levelOne = array();
        $levelTwo = array();
        $levelThree = array();

        foreach ($deleteArr as $delete) {
            switch ($delete['level']) {
                case 1 :
                    $levelOne[] = $delete['id'];
                    break;
                case 2 :
                    $levelTwo[] = $delete['id'];
                    break;
                case 3 :
                default :
                    $levelThree[] = $delete['id'];
                    break;
            }
        }
        $count = self::deleteMenuByIds($levelThree);
        $count = array_merge($count, self::deleteMenuByIds($levelTwo));
        $count = array_merge($count, self::deleteMenuByIds($levelOne));
        if(count($count)) {
            return array('status' => false, 'msg' => 'error_some_menu_has_child');
        }
        return array('status' => 'true');
    }

    /**
     * 根据主键数组删除一个或者多个菜单
     *
     * @param $ids
     * @return array
     */
    protected static function deleteMenuByIds($ids) {
        $failure = array();
        foreach ($ids as $id) {
            $result = self::deleteMenu($id);
            if (!$result['status']) {
                $failure[] = $id;
            }
        }
        return $failure;
    }

    /**
     * 删除一个菜单
     * @param $id
     * @return array
     */
    public static function deleteMenu($id) {
        $menu = Menu::find($id);
        $has = self::checkHasChild($menu->number);
        if($has) {
            return array('status' => false, 'msg' => 'error_menu_has_children');
        }
        $name = $menu->name;
        Menu::destroy($id);
        return array('status' => true, 'name' => $name);
    }

    /**
     * 修改一个菜单信息
     *
     * @param $id
     * @param $name
     * @param string $url
     * @param int $sort
     * @param int $display
     * @return array
     */
    public static function updateMenu($id, $name, $url = '', $sort = 0, $display = self::MENU_SHOW) {
        $menu = Menu::find($id);
        if(empty($menu)) {
            return array('status' => true);
        }
        $menu->name = $name;
        $menu->url = $url;
        $menu->sort = $sort;
        $menu->display = $display;
        $menu->save();

        return array('status' => true, 'id' => $menu->id);
    }

    /**
     * 按$offset,$limit,$keyword条件获取多条菜单记录
     *
     * @param int $offset
     * @param int $limit
     * @param string $keyword
     * @return $this|array|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder|static|static[]
     */
    public static function getMenus($offset = 0, $limit = self::NUM_PER_PAGE, $keyword = '') {
        $menu = new Menu();
        return $menu->getMenus($offset, $limit, $keyword);
    }

    /**
     * 按权限获取菜单
     */
    public static function getAllDisplayMenus() {
        return  Menu::where('display',self::MENU_SHOW)->orderBy('number')->offset(0)->limit(200)->get();
    }

    /**
     * 按关键字统计菜单记录条数
     *
     * @param string $keyword
     * @return int
     */
    public static function countMenus($keyword = '') {
       if($keyword) {
           $count = Menu::where('name', 'like', "%$keyword%")->orwhere('number', 'like', "%$keyword%")->count();
       }else{
           $count = Menu::count();
       }
        return $count;
    }

    /**
     * 获取一个菜单以及该菜单的父菜单名称
     *
     * @param $id
     * @return mixed
     */
    public static function getMenuAndParentNameById($id) {
        $menu = new Menu();
        return $menu->getMenuAndParentNameById($id);
    }


    /**
     * 显示上级菜单
     * 限制菜单级别为3，所以上级菜单最多显示2级
     *
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getSuperMenu() {
        $menus = Menu::where('level','<', self::MENU_CLASS )->where('display',self::MENU_SHOW)->orderBy('group')->orderBy('level')->orderBy('sort')->orderBy('id')->offset(0)->limit(100)->get();
        return $menus;
    }

    public static function getMenuByIds($menuIds) {
        return  Menu::where('display',self::MENU_SHOW)->whereIn('id', $menuIds)->orderBy('number')->offset(0)->limit(200)->get();
    }

    /**
     * 获取上级菜单信息
     *
     * @param $parentId
     * @return Menu|\Illuminate\Support\Collection|null|static
     */
    protected static function getParent($parentId) {
        if($parentId) {
            $parent = Menu::find($parentId);
        }else {
            $parent = new Menu();
            $parent->number = '01';
            $parent->parent_id = 0;
            $parent->group = 0;
            $parent->level = 0;
        }
        return $parent;
    }

    /**
     * 生成菜单编号
     *
     * @param int $parentId
     * @param string @parentNo
     * @return string
     */
    protected static function generateMenuNumber($parentId = self::DEFAULT_PARENT, $parentNo) {
        $last = Menu::where('parent_id', $parentId)->orderBy('created_at', 'desc')->first();

        if($last) {
            $last = intval(substr($last->number, -3, 3));
            if($last >= self::MAX_CHILD) {
                return false;
            }
            $no = str_pad($last + 1, 3, '0', STR_PAD_LEFT);
        }else {
            $no = '001';
        }
        $number = $parentNo . $no;
        return $number;
    }

    /**
     * 检查菜单是否有子菜单，返回
     * @param $number
     * @return int
     */
    private static function checkHasChild($number) {
        $count =  Menu::where('number', 'like', "$number%")->count();
        return $count > 1 ? true : false;
    }
}