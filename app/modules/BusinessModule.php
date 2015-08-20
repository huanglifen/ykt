<?php namespace App\Module;

use App\Model\Business;

/**
 * 商户module层
 *
 * @package App\Module
 */
class BusinessModule extends BaseModule {

    /**
     * 添加一个用户
     *
     * @param $data
     * @return bool
     */
    public static function addBusiness($data) {
        $business = new Business();
        $business = self::commonBusiness($data, $business);
        $business->password = $data['password'];
        $business->save();
        return array('status' => true);
    }

    /**
     * 按主键删除商户
     *
     * @param $id
     * @return array
     */
    public static function deleteBusinessById($id) {
        Business::destroy($id);
        return array('status' => true);
    }
    /**
     * 更新一个商户
     *
     * @param $data
     * @return bool
     */
    public static function updateBusiness($data) {
        $business = Business::find($data['id']);
        $business = self::commonBusiness($data, $business);
        $business->password = $data['password'] ? self::hash($data['password']) : $business->password;
        $business->update();
        return array('status' => true);
    }

    /**
     * 按主键获取商户
     *
     * @param $id
     * @return \Illuminate\Support\Collection|null|static
     */
    public static function getBusinessById($id) {
        return Business::where('id', $id)->selectRaw('id, name, number, account, tel, contacter, bank_type, industry, city_id, lng, lat')->first();
    }

    /**
     * 按条件获取商户
     *
     * @param $keyword
     * @param $cityId
     * @param $districtId
     * @param $offset
     * @param $limit
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getBusiness($keyword, $cityId, $districtId, $offset, $limit) {
        $business = new Business();
        $business = $business->leftJoin('area', 'area.id', '=', 'business.city_id');
        if($cityId) {
            $business = $business->where('business.city_id', "$cityId");
            if($districtId) {
                $business = $business->where('business.district_id', $districtId);
            }
        }
        if($keyword) {
            $business = $business->where('business.name', 'like', "%$keyword%")->orWhere('business.number', 'like', "%$keyword%")->orWhere('business.account', 'like', "%$keyword%");
        }
        if($limit) {
            $business = $business->offset($offset)->limit($limit);
        }
        $business = $business->selectRaw("business.id, business.name, business.number, business.account,business.tel, business.contacter, business.bank_type, business.industry, business.city_id,area.name as cityName");
        $business = $business->get();
        return $business;
    }

    /**
     * 按条件统计商户
     *
     * @param $keyword
     * @param $cityId
     * @param $districtId
     * @return int
     */
    public static function countBusiness($keyword, $cityId, $districtId) {
        $business = new Business();
        if($cityId) {
            $business = $business->where('city_id', $cityId);
            if($districtId) {
                $business = $business->where('district_id', $districtId);
            }
        }
        if($keyword) {
            $business = $business->where('name', 'like', "%$keyword%")->orWhere('number', 'like', "%$keyword%");
            $business = $business->orWhere('account', 'like', "%$keyword%");
        }
        return $business->count();
    }

    public static function getBusinessIndustry(&$business) {
        $industry = IndustryModule::getIndustries('', -1);
        foreach ($business as &$b) {
            $b->industryStr = "";
            $flag = false;
            $businessIndustry = explode(',', $b->industry);
            foreach ($businessIndustry as $bi) {
                foreach ($industry as $i) {
                    if ($i->id == $bi) {
                        if ($flag) {
                            $b->industryStr .= ",";
                        }
                        $b->industryStr .= $i->name;
                        $flag = true;
                        break;
                    }
                }
            }
        }
        return $business;
    }

    /**
     * 添加、更新商户信息公共部分
     *
     * @param $data
     * @param $business
     * @return mixed
     */
    protected static function commonBusiness($data, $business) {
        $business->city_id = $data['cityId'];
        $business->district_id = $data['districtId'];
        $business->name = $data['name'];
        $business->account = $data['account'];
        $business->number = $data['number'];
        $business->integral_number = $data['integralNumber'];
        $business->address = $data['address'];
        $business->business_district_id = $data['circle'];
        $business->bank_type = $data['bankType'];
        $business->tariff = $data['tariff'];
        $business->license = $data['license'];
        $business->contacter = $data['contacter'];
        $business->email = $data['email'];
        $business->phone = $data['phone'];
        $business->tel = $data['tel'];
        $business->qq = $data['qq'];
        $business->card_type = $data['cardType'];
        $business->industry = $data['industry'];
        $business->discount = $data['discount'];
        $business->star = $data['star'];
        $business->status = $data['status'];
        $business->level = $data['level'];
        $business->picture = $data['picture'];
        $business->promotion_pic = $data['promotion'];
        $business->description = $data['description'];
        $business->app_description = $data['appDescription'];
        $business->lng = $data['lng'];
        $business->lat = $data['lat'];
        $business->unique_number = $data['uniqueNumber'];
        return $business;
    }
}