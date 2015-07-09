<?php namespace App\Module;

use App\Model\BusinessDistrict;
use Illuminate\Support\Facades\DB;

class BusinessDistrictModule extends BaseModule {
    /**
     * 添加一个商圈
     *
     * @param $name
     * @param $cityId
     * @param $districtId
     * @param $address
     * @param $lat
     * @param $lng
     * @return bool
     */
    public static function addCircle($name, $cityId, $districtId, $address, $lat, $lng, $keyword) {
        $circle = new BusinessDistrict();
        $circle->name = $name;
        $circle->city_id = $cityId;
        $circle->district_id = $districtId;
        $circle->address = $address;
        $circle->lat = $lat;
        $circle->lng = $lng;
        $circle->keyword = $keyword;
        $circle->save();
        return true;
    }

    /**
     * 删除一个商圈
     *
     * @param $id
     * @return bool
     */
    public static function deleteCircle($id) {
        BusinessDistrict::destroy($id);
        return true;
    }

    /**
     * 更新一个商圈
     *
     * @param $id
     * @param $name
     * @param $cityId
     * @param $districtId
     * @param $address
     * @param $lat
     * @param $lng
     * @return bool
     */
    public static function updateCircle($id, $name, $cityId, $districtId, $address, $lat, $lng, $keyword) {
        $circle = BusinessDistrict::find($id);
        if(empty($circle)) {
            return array('status', 'msg' => 'error_circle_not_exist');
        }
        $circle->name = $name;
        $circle->city_id = $cityId;
        $circle->district_id = $districtId;
        $circle->address = $address;
        $circle->lat = $lat;
        $circle->lng = $lng;
        $circle->keyword = $keyword;
        $circle->update();
        return array('status' => true);
    }

    /**
     * 按条件获取商圈记录
     *
     * @param string $keyword
     * @param int $cityId
     * @param int $districtId
     * @param int $offset
     * @param int $limit
     * @return $this|BusinessDistrict|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder|static|static[]
     */
    public static function getCircle($keyword = '', $cityId = AreaModule::CAPITAL, $districtId = 0, $offset = 0, $limit = 500) {
        $circle = new BusinessDistrict();
        if($keyword) {
            $circle = $circle->where('name', 'like', "%$keyword%");
        }
        if($cityId) {
            $circle = $circle->where('city_id', $cityId);
        }
        if($districtId) {
            $circle = $circle->where('district_id', $districtId);
        }
        if($limit) {
            $circle = $circle->offset($offset)->limit($limit);
        }
        $circle = $circle->get();
        return $circle;
    }

    /**
     * 按条件统计商圈记录
     *
     * @param string $keyword
     * @param int $cityId
     * @param int $districtId
     * @return BusinessDistrict|\Illuminate\Database\Eloquent\Builder|int|static
     */
    public static function countCircle($keyword = '', $cityId = AreaModule::CAPITAL, $districtId = 0) {
        $circle = new BusinessDistrict();
        if($keyword) {
            $circle = $circle->where('name', 'like', "%$keyword%");
        }
        if($cityId) {
            $circle = $circle->where('city_id', $cityId);
        }
        if($districtId) {
            $circle = $circle->where('district_id', $districtId);
        }
        $circle = $circle->count();
        return $circle;
    }

    /**
     * 按主键获取商圈
     *
     * @param $id
     * @return BusinessDistrict|array
     */
    public static function getCircleById($id) {
        $circle = new BusinessDistrict();
        $circle = $circle->getCircleById($id);
        return $circle;
    }
}