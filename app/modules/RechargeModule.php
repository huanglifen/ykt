<?php namespace App\Module;

use App\Model\Recharge;

/**
 * 充值module层
 *
 * @package App\Module
 */
class RechargeModule extends BaseModule {
    const STATUS_NOT_PAYED = 1; //未支付
    const STATUS_SUCCESS = 2; //交易成功
    const STATUS_FAIL = 3; //交易失败
    const PAY_TYPE_WEIXIN = 1; //微信支付
    const PAY_TYPE_ALIPAY = 2; //支付宝支付
    const PAY_TYPE_UNION = 3; //银联

    /**
     * 按条件获取充值记录
     *
     * @param $startTime
     * @param $endTime
     * @param $status
     * @param $orderNo
     * @param $tradeNo
     * @param $cardNo
     * @param $type
     * @param $minMount
     * @param $maxMount
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getRecharges($startTime, $endTime, $status, $orderNo, $tradeNo, $cardNo, $type, $minMount, $maxMount) {
        $recharge = new Recharge();
        if($startTime) {
            $recharge = $recharge->where("created_at", '>=', $startTime);
        }
        if($endTime) {
            $recharge = $recharge->where("created_at", '<=', $endTime);
        }
        if($status) {
            $recharge = $recharge->where('status', $status);
        }
        if($orderNo) {
            $recharge = $recharge->where("order_no", 'like', "%$orderNo%");
        }
        if($tradeNo) {
            $recharge = $recharge->where("trade_no", 'like', "%$tradeNo%");
        }
        if($cardNo) {
            $recharge = $recharge->where("cardno", 'like', "%$cardNo%");
        }
        if($type) {
            $recharge = $recharge->where("type", $type);
        }
        if($minMount) {
            $recharge = $recharge->where("pay_mount", '>=', $minMount);
        }
        if($maxMount) {
            $recharge = $recharge->where("pay_mount", '<=', $maxMount);
        }
        return $recharge->get();
    }

    /**
     * 按条件统计充值记录
     *
     * @param $startTime
     * @param $endTime
     * @param $status
     * @param $orderNo
     * @param $tradeNo
     * @param $cardNo
     * @param $type
     * @param $minMount
     * @param $maxMount
     * @return int
     */
    public static function countRecharges($startTime, $endTime, $status, $orderNo, $tradeNo, $cardNo, $type, $minMount, $maxMount) {
        $recharge = new Recharge();
        if($startTime) {
            $recharge = $recharge->where("created_at", '>=', $startTime);
        }
        if($endTime) {
            $recharge = $recharge->where("created_at", '<=', $endTime);
        }
        if($status) {
            $recharge = $recharge->where('status', $status);
        }
        if($orderNo) {
            $recharge = $recharge->where("order_no", 'like', "%$orderNo%");
        }
        if($tradeNo) {
            $recharge = $recharge->where("trade_no", 'like', "%$tradeNo%");
        }
        if($cardNo) {
            $recharge = $recharge->where("cardno", 'like', "%$cardNo%");
        }
        if($type) {
            $recharge = $recharge->where("type", $type);
        }
        if($minMount) {
            $recharge = $recharge->where("pay_mount", '>=', $minMount);
        }
        if($maxMount) {
            $recharge = $recharge->where("pay_mount", '<=', $maxMount);
        }
        return $recharge->count();
    }
}