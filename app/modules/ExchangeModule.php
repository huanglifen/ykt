<?php namespace App\Module;

use App\Model\Exchange;

/**
 * 交易 module层
 *
 * @package App\Module
 */
class ExchangeModule extends BaseModule {
    const STATUS_NOT_PAYED = 1; //未支付
    const STATUS_SUCCESS = 2; //交易成功
    const STATUS_FAIL = 3; //交易失败
    const PAY_TYPE_WEIXIN = 1; //微信支付
    const PAY_TYPE_ALIPAY = 2; //支付宝支付
    const PAY_TYPE_UNION = 3; //银联
    const TYPE_RECHARGE = 1; //充值
    const TYPE_PAYMENT = 2; //消费

    /**
     * 按条件获取交易记录
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
     * @param $offset
     * @param $limit
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getExchanges($startTime, $endTime, $status, $orderNo, $tradeNo, $cardNo, $type, $minMount, $maxMount, $offset, $limit) {
        $exchange = new Exchange();
        $exchange = $exchange->leftJoin('business', function($join) {
            $join->on("business.id", '=', 'exchange.business_id')->where("exchange.type", '=', self::TYPE_PAYMENT);
        });
        if($startTime) {
            $exchange = $exchange->where("created_at", '>=', $startTime);
        }
        if($endTime) {
            $exchange = $exchange->where("created_at", '<=', $endTime);
        }
        if($status) {
            $exchange = $exchange->where('status', $status);
        }
        if($orderNo) {
            $exchange = $exchange->where("order_no", 'like', "%$orderNo%");
        }
        if($tradeNo) {
            $exchange = $exchange->where("trade_no", 'like', "%$tradeNo%");
        }
        if($cardNo) {
            $exchange = $exchange->where("cardno", 'like', "%$cardNo%");
        }
        if($type) {
            $exchange = $exchange->where("type", $type);
        }
        if($minMount) {
            $exchange = $exchange->where("pay_mount", '>=', $minMount);
        }
        if($maxMount) {
            $exchange = $exchange->where("pay_mount", '<=', $maxMount);
        }
        if($limit) {
            $exchange = $exchange->offset($offset)->limit($limit);
        }
        $exchange = $exchange->selectRaw("exchange.*, business.name as businessName");
        return $exchange->get();
    }

    /**
     * 按条件统计交易记录
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
    public static function countExchanges($startTime, $endTime, $status, $orderNo, $tradeNo, $cardNo, $type, $minMount, $maxMount) {
        $exchange = new Exchange();
        if($startTime) {
            $exchange = $exchange->where("created_at", '>=', $startTime);
        }
        if($endTime) {
            $exchange = $exchange->where("created_at", '<=', $endTime);
        }
        if($status) {
            $exchange = $exchange->where('status', $status);
        }
        if($orderNo) {
            $exchange = $exchange->where("order_no", 'like', "%$orderNo%");
        }
        if($tradeNo) {
            $exchange = $exchange->where("trade_no", 'like', "%$tradeNo%");
        }
        if($cardNo) {
            $exchange = $exchange->where("cardno", 'like', "%$cardNo%");
        }
        if($type) {
            $exchange = $exchange->where("type", $type);
        }
        if($minMount) {
            $exchange = $exchange->where("pay_mount", '>=', $minMount);
        }
        if($maxMount) {
            $exchange = $exchange->where("pay_mount", '<=', $maxMount);
        }
        return $exchange->count();
    }
}