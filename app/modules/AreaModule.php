<?php namespace App\Module;

use App\Model\Area;

/**
 * 地区module层
 *
 * @package App\Module
 */
class AreaModule extends BaseModule {
    const PROVINCE_ID = 13;
    const CAPITAL = 1301;

    public static function getAreaByParentId($parent = self::PROVINCE_ID) {
        $city = new Area();
        $city = $city->where('parent', $parent)->orderBy('id')->get();
        return $city;
    }

}