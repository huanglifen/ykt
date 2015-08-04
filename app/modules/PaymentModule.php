<?php namespace App\Module;

use App\Model\Payment;

/**
 * 生活缴费module层
 *
 * @package App\Module
 */
class PaymentModule extends BaseModule {
    const TRANSACTION_SUCCESS = 1;
    const TRANSACTION_DEALING = 2;
    const TRANSACTION_FAILURE = 3;

    /**
     * 按条件获取缴费交易记录
     *
     * @param int $startTime
     * @param int $endTime
     * @param string $orderNo
     * @param int $category
     * @param int $status
     * @param int $minMount
     * @param int $maxMount
     * @param string $orderNo
     * @param string $payAccount
     * @param string $account
     * @param string $customerName
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getPayInfo($startTime = 0, $endTime = 0, $category = 0, $status = 0, $minMount = 0, $maxMount = 0, $orderNo = '', $payAccount = '', $account = '', $customerName = '') {
        $pay = new Payment();
        $pay = $pay->leftJoin('customer', 'customer.id', '=', 'payment.uid');
        if($startTime) {
            $pay = $pay->where('payment.created_at', '>=', $startTime);
        }
        if($endTime) {
            $pay = $pay->where('payment.created_at', '<=', $endTime);
        }
        if($category) {
            $pay = $pay->where('payment.category', $category);
        }
        if($status) {
            $pay = $pay->where('payment.status', $status);
        }
        if($minMount) {
            $pay = $pay->where("payment.mount", '>=', $minMount);
        }
        if($maxMount) {
            $pay = $pay->where('payment.mount', '<=', $maxMount);
        }
        if($orderNo) {
            $pay = $pay->where('payment.order_no', $orderNo);
        }
        if($payAccount) {
            $pay = $pay->where('payment.pay_account', $payAccount);
        }
        if($account) {
            $pay = $pay->where('payment.account', $account);
        }
        if($customerName) {
            $pay = $pay->where('customer.username', 'like', "%$customerName%");
        }
        $pay = $pay->selectRaw("payment.*, customer.username as customerName");
        return $pay->get();
    }

    /**
     * 按条件统计交易记录
     *
     * @param int $startTime
     * @param int $endTime
     * @param string $orderNo
     * @param int $category
     * @param int $status
     * @param int $minMount
     * @param int $maxMount
     * @param string $orderNo
     * @param string $payAccount
     * @param string $account
     * @param string $customerName
     * @return mixed
     */
    public static function countPayInfo($startTime = 0, $endTime = 0, $category = 0, $status = 0, $minMount = 0, $maxMount = 0, $orderNo = '', $payAccount = '', $account = '', $customerName = '') {
        $pay = new Payment();
        $pay = $pay->leftJoin('customer', 'customer.id', '=', 'payment.uid');
        if($startTime) {
            $pay = $pay->where('payment.created_at', '>=', $startTime);
        }
        if($endTime) {
            $pay = $pay->where('payment.created_at', '<=', $endTime);
        }
        if($category) {
            $pay = $pay->where('payment.category', $category);
        }
        if($status) {
            $pay = $pay->where('payment.status', $status);
        }
        if($minMount) {
            $pay = $pay->where("payment.mount", '>=', $minMount);
        }
        if($maxMount) {
            $pay = $pay->where('payment.mount', '<=', $maxMount);
        }
        if($orderNo) {
            $pay = $pay->where('payment.order_no', $orderNo);
        }
        if($payAccount) {
            $pay = $pay->where('payment.pay_account', $payAccount);
        }
        if($account) {
            $pay = $pay->where('payment.account', $account);
        }
        if($customerName) {
            $pay = $pay->where('customer.username', 'like', "%$customerName%");
        }
        return $pay->count();
    }
}