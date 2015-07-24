<?php namespace App\Module;

use App\Model\Partner;

/**
 * 合作伙伴module层
 *
 * @package App\Module
 */
class PartnerModule extends BaseModule {

    /**
     * 添加合作伙伴
     *
     * @param $name
     * @param $picture
     * @param $sort
     * @param $display
     * @return array
     */
    public static function addPartner($name, $picture, $sort, $display) {
        $partner = new Partner();
        $partner->name = $name;
        $partner->picture = $picture;
        $partner->sort = $sort;
        $partner->display = $display;

        $partner->save();
        return array('status' => true, 'id' => $partner->id);
    }

    /**
     * 更新一个合作伙伴
     *
     * @param $id
     * @param $name
     * @param $picture
     * @param $sort
     * @param $display
     * @return array
     */
    public static function updatePartner($id, $name, $picture, $sort, $display) {
        $partner = Partner::find($id);
        if(empty($partner)) {
            return array('status' => true, 'msg' => 'error_id_not_exist');
        }

        $partner->name = $name;
        $partner->picture = $picture;
        $partner->sort = $sort;
        $partner->display = $display;

        $partner->save();
        return array('status' => true);
    }

    /**
     * 删除一个合作伙伴
     *
     * @param $id
     * @return array
     */
    public static function deletePartner($id) {
        $partner = Partner::find($id);
        if(empty($partner)) {
            return array('status' => false, 'msg' => 'error_id_not_exist');
        }
        Partner::destroy($id);
        return array('status' => true);
    }

    /**
     * 获取合作伙伴
     *
     * @param int $offset
     * @param int $limit
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getPartners($offset = 0, $limit = 0) {
        $partner = new Partner();
        if($limit) {
            $partner = $partner->offset($offset)->limit($limit);
        }
        return $partner->get();
    }

    /**
     * 统计合作伙伴
     *
     * @return int
     */
    public static function countPartners() {
        $partner = new Partner();
        return $partner->count();
    }

    /**
     * 按主键查询合作伙伴
     *
     * @param $id
     * @return \Illuminate\Support\Collection|null|static
     */
    public static function getPartnerById($id) {
        return Partner::find($id);
    }
}