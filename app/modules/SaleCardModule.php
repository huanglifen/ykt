<?php namespace App\Module;

use App\Model\SaleCard;

/**
 * 在线售卡module层
 *
 * @package App\Module
 */
class SaleCardModule extends BaseModule {
    const STATUS_SUBMIT = 1; //已提交
    const STATUS_DEALING = 2; //处理中
    const STATUS_SUCCESS = 3; //交易成功
    const STATUS_FAIL = 4; //交易失败

    const POST_STATUS_NON_DELIVERY = 1; //未发货
    const POST_STATUS_DELIVERY = 2; //已发货，邮寄中
    const POST_STATUS_RECEIVED = 3; //已收件



    /**
     * 按条件获取在线售卡记录
     *
     * @param $startTime
     * @param $endTime
     * @param $status
     * @param $orderNo
     * @param $customerName
     * @param $cardNo
     * @param $tel
     * @param $postStatus
     * @param $minMount
     * @param $maxMount
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getSaleCards($startTime, $endTime, $status, $orderNo, $customerName, $cardNo, $tel, $postStatus, $minMount, $maxMount) {
        $saleCards = new SaleCard();
        if($startTime) {
            $saleCards = $saleCards->where("created_at", '>=', $startTime);
        }
        if($endTime) {
            $saleCards = $saleCards->where("created_at", '<=', $endTime);
        }
        if($status) {
            $saleCards = $saleCards->where("status", $status);
        }
        if($orderNo) {
            $saleCards = $saleCards->where("order_no", 'like', "%$orderNo%");
        }
        if($customerName) {
            $saleCards = $saleCards->where("customer_name", 'like', "%$customerName%");
        }
        if($cardNo) {
            $cardNo = self::encrypt($cardNo, "E");
            $saleCards = $saleCards->where("cardno", $cardNo);
        }
        if($tel) {
            $saleCards = $saleCards->where("tel", 'like', "%$tel%");
        }
        if($postStatus) {
            $saleCards = $saleCards->where('post_status', $postStatus);
        }
        if($minMount) {
            $saleCards = $saleCards->where("pay_mount", '>=', $minMount);
        }
        if($maxMount) {
            $saleCards = $saleCards->where("pay_mount", '<=', $maxMount);
        }
        $saleCards = $saleCards->get();
        $saleCards = self::decryptCardNo($saleCards);
        return $saleCards;
    }

    /**
     * 按条件统计在线售卡记录
     *
     * @param $startTime
     * @param $endTime
     * @param $status
     * @param $orderNo
     * @param $customerName
     * @param $cardNo
     * @param $tel
     * @param $postStatus
     * @param $minMount
     * @param $maxMount
     * @return int
     */
    public static function countSaleCards($startTime, $endTime, $status, $orderNo, $customerName, $cardNo, $tel, $postStatus, $minMount, $maxMount) {
        $saleCards = new SaleCard();
        if($startTime) {
            $saleCards = $saleCards->where("created_at", '>=', $startTime);
        }
        if($endTime) {
            $saleCards = $saleCards->where("created_at", '<=', $endTime);
        }
        if($status) {
            $saleCards = $saleCards->where("status", $status);
        }
        if($orderNo) {
            $saleCards = $saleCards->where("order_no", 'like', "%$orderNo%");
        }
        if($customerName) {
            $saleCards = $saleCards->where("customer_name", 'like', "%$customerName%");
        }
        if($cardNo) {
            $cardNo = self::encrypt($cardNo, "E");
            $saleCards = $saleCards->where("cardno", $cardNo);
        }
        if($tel) {
            $saleCards = $saleCards->where("tel", 'like', "%$tel%");
        }
        if($postStatus) {
            $saleCards = $saleCards->where('post_status', $postStatus);
        }
        if($minMount) {
            $saleCards = $saleCards->where("pay_mount", '>=', $minMount);
        }
        if($maxMount) {
            $saleCards = $saleCards->where("pay_mount", '<=', $maxMount);
        }
        return $saleCards->count();
    }

    /**
     * 解密卡号
     *
     * @param $saleCards
     * @return mixed
     */
    public static function decryptCardNo($saleCards) {
        foreach($saleCards as &$sale) {
            $sale->cardno = self::encrypt($sale->cardno, "D");
        }
        return $saleCards;
    }
}