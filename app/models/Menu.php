<?php namespace App\Model;
/**
 * 菜单model层
 * @package App\Model
 */
class Menu extends \Eloquent {
    protected $table = 'menu';

    /**
     * 按条件查询菜单记录
     *
     * @param $offset
     * @param $limit
     * @param $keyword
     * @return array
     */
    public function getMenus($offset, $limit, $keyword) {
        $sql = "select t1.*,ifnull(t2.name, '无') as parent,ifnull(t3.name,'无') as groupName from $this->table as t1 ";
        $sql .= "left join (select id,name from $this->table) as t2 on t1.parent_id=t2.id ";
        $sql .= "left join (select id,name,number from $this->table) as t3 on t1.group=t3.number ";
        if($keyword) {
            $sql .= " where t1.name like '%$keyword%' or t1.number like '%$keyword%' ";
        }
        $sql .= "order by number ";
        if($limit > 0) {
            $sql .= "limit $offset,$limit";
        }
        return \DB::select($sql);
    }

    /**
     * 查询id为$id的菜单以及该菜单的父菜单名
     * @param $id
     * @return mixed
     */
    public function getMenuAndParentNameById($id) {
        $sql = "select t1.*,ifnull(t2.name, '无') as parent from $this->table as t1 ";
        $sql .= "left join (select id,name from $this->table) as t2 on t1.parent_id=t2.id ";
        $sql .= "where t1.id='$id'";
        $menu =  \DB::select($sql);
        if(count($menu)) {
            return $menu[0];
        }
        return $menu;
    }
}