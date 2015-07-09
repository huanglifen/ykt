<?php namespace App\Model;

/**
 * 商圈model层
 *
 * @package App\Model
 */
class BusinessDistrict extends \Eloquent {
    protected $table = 'business_district';
    protected $areaTable = 'area';

    /**
     * 按条件获取商圈记录
     *
     * @param $id
     * @return array
     */
    public function getCircleById($id) {
        $sql = "select a.*, b.name as cityName, c.name as districtName from $this->table a ";
        $sql .= "left join $this->areaTable b on b.id = a.city_id ";
        $sql .= "left join $this->areaTable c on c.id = a.district_id ";
        $sql .=" where a.id = $id ";
        $result = \DB::select($sql);
        if(count($result)) {
            return $result[0];
        }else {
            return array();
        }
    }
}