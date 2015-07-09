<?php namespace App\Module;
use App\Model\Coupon;

/**
 * 优惠券module层
 *
 * @package App\Module
 */
class CouponModule extends BaseModule {

    /**
     * 添加一个优惠券
     *
     * @param $businessId
     * @param $title
     * @param $picture
     * @param $amount
     * @param $remainAmount
     * @param $cityId
     * @param $startTime
     * @param $endTime
     * @param $content
     * @param $status
     * @return array
     */
    public static function addCoupon($businessId, $title, $picture, $amount, $remainAmount, $cityId, $startTime, $endTime, $content, $status) {
        $coupon = new Coupon();

        $coupon->business_id = $businessId;
        $coupon->title = $title;
        $coupon->picture = $picture;
        $coupon->amount = $amount;
        $coupon->remain_amount = $remainAmount;
        $coupon->city_id = $cityId;
        $coupon->start_time = $startTime;
        $coupon->end_time = $endTime;
        $coupon->content = $content;
        $coupon->status = $status;

        $coupon->save();
        return array('status' => true);
    }

    /**
     * 删除一个优惠券
     *
     * @param $id
     * @return array
     */
    public static function deleteCoupon($id) {
        Coupon::destroy($id);
        return array('status' => true);
    }

    /**
     * 更新优惠券
     *
     * @param $id
     * @param $businessId
     * @param $title
     * @param $picture
     * @param $amount
     * @param $remainAmount
     * @param $cityId
     * @param $startTime
     * @param $endTime
     * @param $content
     * @param $status
     * @return array
     */
    public static function updateCoupon($id, $businessId, $title, $picture, $amount, $remainAmount, $cityId, $startTime, $endTime, $content, $status) {
        $coupon = Coupon::find($id);
        if(empty($coupon)) {
            return array('status' => true, 'msg' => 'coupon_not_exist');
        }

        $coupon->title = $title;
        $coupon->picture = $picture;
        $coupon->amount = $amount;
        $coupon->remain_amount = $remainAmount;
        $coupon->city_id = $cityId;
        $coupon->start_time = $startTime;
        $coupon->end_time = $endTime;
        $coupon->content = $content;
        $coupon->status = $status;

        $coupon->update();
        return array('status' => true);
    }

    /**
     * 按条件获取优惠券
     *
     * @param $businessId
     * @param $keyword
     * @param int $offset
     * @param int $limit
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getCoupon($businessId, $keyword, $offset = 0, $limit = 0) {
        $coupon = new Coupon();
        $coupon = $coupon->where('business_id', $businessId);
        if($keyword) {
            $coupon = $coupon->where('title', 'like', "%$keyword%");
        }
        if($limit > 0) {
            $coupon = $coupon->offset($offset)->limit($limit);
        }
        return $coupon->get();
    }

    /**
     * 按条件统计优惠券
     *
     * @param $businessId
     * @param $keyword
     * @return int
     */
    public static function countCoupon($businessId, $keyword) {
        $coupon = new Coupon();
        $coupon = $coupon->where('business_id', $businessId);
        if($keyword) {
            $coupon = $coupon->where('title', 'like', "%$keyword%");
        }
        return $coupon->count();
    }

    /**
     * 按主键进行查询
     *
     * @param $id
     * @return \Illuminate\Support\Collection|null|static
     */
    public static function getCouponById($id) {
        return Coupon::find($id);
    }

}