<?php namespace App\Module;

use App\Model\BusinessType;

/**
 * 商户促销类型module层
 *
 * @package App\Module
 */
class BusinessTypeModule extends BaseModule {

    /**
     * 添加一个商户促销类型
     *
     * @param $name
     * @param $status
     * @param $sort
     * @return array
     */
    public static function addBusinessType($name, $status, $sort) {
        $businessType = new BusinessType();
        $businessType->name = $name;
        $businessType->status = $status ? $status :self::STATUS_OPEN;
        $businessType->sort = $sort;
        $businessType->save();
        return array('status' => true, 'id' => $businessType->id);
    }

    /**
     * 删除一个促销类型
     *
     * @param $id
     * @return array
     */
    public static function deleteBusinessType($id) {
        $businessType = BusinessType::find($id);
        if(empty($businessType)) {
            return array('status' => false, 'msg' => 'error_id_not_exist');
        }
        BusinessType::destroy($id);
        return array('status' => true);
    }

    /**
     * 更新一个促销类型
     *
     * @param $id
     * @param $name
     * @param $status
     * @param $sort
     * @return array
     */
    public static function updateBusinessType($id, $name, $status, $sort) {
        $businessType = BusinessType::find($id);
        if(empty($businessType)) {
            return array('status' => false, 'msg' => 'error_id_not_exist');
        }
        $businessType->name = $name;
        $businessType->status = $status ? $status :self::STATUS_OPEN;
        $businessType->sort = $sort;
        $businessType->save();
        return array('status' => true);
    }

    /**
     * 按主键获取商户促销
     *
     * @param $id
     * @return \Illuminate\Support\Collection|null|static
     */
    public static function getBusinessTypeById($id) {
        return BusinessType::find($id);
    }

    /**
     * 按条件获取促销类型
     *
     * @param $name
     * @param $offset
     * @param $limit
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getBusinessTypes($name, $offset, $limit) {
        $businessType = new BusinessType();
        if($name) {
            $businessType = $businessType->where('name', 'like', "%$name%");
        }
        if($limit) {
            $businessType = $businessType->offset($offset)->limit($limit);
        }
        return $businessType->get();
    }

    /**
     * 按条件统计促销类型
     *
     * @param $name
     * @return int
     */
    public static function countBusinessTypes($name) {
        $businessType = new BusinessType();
        if($name) {
            $businessType = $businessType->where('name', 'like', "%$name%");
        }
        return $businessType->count();
    }
}