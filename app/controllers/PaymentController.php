<?php namespace App\Controllers;

use App\Module\BusinessModule;
use App\Module\PaymentModule;
use App\Module\PaySetModule;

/**
 * 生活缴费控制器
 *
 * @package App\Controllers
 */
class PaymentController extends BaseController {
    //交易状态
    public $statusArr = array(
        0 => '全部',
        PaymentModule::TRANSACTION_SUCCESS => '交易成功',
        PaymentModule::TRANSACTION_DEALING => '处理中',
        PaymentModule::TRANSACTION_FAILURE => '交易失败'
    );

    //关键信息
    public $keywordArr = array(
        1 => '订单编号',
        2 => '客户名称',
        3 => '缴费账号',
        4 => '支付账号'
    );

    //缴费类型
    public $payTypeArr = array(
        0 => '全部',
        PaySetModule::CATEGORY_MOBILE => '通讯费',
        PaySetModule::CATEGORY_TV => '有线电视',
        PaySetModule::CATEGORY_GAS => '燃气缴费',
        PaySetModule::CATEGORY_INSURANCE => '保险',
        PaySetModule::CATEGORY_YKT => '一卡通消费'
    );

    public $payDateArr = array(
        0 => '全部',
        1 => '今天',
        2 => '一个月',
        3 => '三个月'
    );

    /**
     * 显示交易查询页面
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getIndex() {
        if(! $this->isLogin()) {
            return \Redirect::to('/login');
        }
        $status = $this->statusArr;
        $payType = $this->payTypeArr;
        $keyword = $this->keywordArr;
        $payDate = $this->payDateArr;
        $this->data = compact('status', 'payType', 'keyword', 'payDate');
        return $this->showView('pay.search');
    }

    /**
     * 获取查询记录请求
     *
     * @return string
     */
    public function getPayment() {
        $this->outputUserNotLogin();

        $offset = $this->getParam('iDisplayStart');
        $limit = $this->getParam('iDisplayLength');
        $startTime = $this->getParam('startTime');
        $endTime = $this->getParam('endTime');
        $keyword = $this->getParam('keyword');
        $type = $this->getParam('type');
        $category = $this->getParam('category');
        $status = $this->getParam('status');
        $minMount = $this->getParam('minMount');
        $maxMount = $this->getParam('maxMount');
        $payDate = $this->getParam('payDate');

        $this->outputErrorIfExist();
        $orderNo = '';
        $payAccount = '';
        $customerName = '';
        $account = '';
        if($type == 1) {
            $orderNo = $keyword;
        } elseif ($type == 3) {
            $payAccount = $keyword;
        } elseif ($type == 4) {
            $account = $keyword;
        } elseif ($type == 2) {
            $customerName = $keyword;
        }

        if($payDate != 0) {
            $now = time();
            $endTime = date("Y-m-d H:i:s", strtotime("tomorrow")-1);
            switch($payDate) {
                case 1 :
                    $startTime = date("Y-m-d H:i:s", mktime(0,0,0,date('m', $now), date('d', $now), date('Y', $now)));
                    break;
                case 2 :
                    $startTime = date("Y-m-d 00:00:00", strtotime("-1 month"));
                    break;
                case 3 :
                    $startTime = date("Y-m-d 00:00:00", strtotime("-3 month"));
                    break;
                default :
                    $startTime = "";
                    break;
            }
        } else {
            $startTime = $startTime ? date("Y-m-d", strtotime($startTime)) : '';
            $endTime = $endTime ? date("Y-m-d 23:59:59", strtotime($endTime)) : '';
        }

        $payment = PaymentModule::getPayInfo($startTime, $endTime,  $category, $status, $minMount, $maxMount, $orderNo, $payAccount, $account, $customerName);
        $total = PaymentModule::countPayInfo($startTime, $endTime,  $category, $status, $minMount, $maxMount, $orderNo, $payAccount, $account, $customerName);

        foreach($payment as &$pay) {
            if(in_array($pay->category, array(
                PaySetModule::CATEGORY_MOBILE,
                PaySetModule::CATEGORY_TV,
                PaySetModule::CATEGORY_GAS ,
                PaySetModule::CATEGORY_INSURANCE))) {
                $pay->businessName = PaySetModule::$typeArr[$pay->business];
            }else{
                $business = BusinessModule::getBusinessById($pay->business);
                if(empty($business)) {
                    $pay->businessName = "";
                } else {
                    $pay->businessName = $business->name;
                }
            }
        }
        $result = array('payment' => $payment, 'iTotalDisplayRecords' => $total, '_iRecordsTotal' => $total, 'iDisplayStart' => $offset, 'iDisplayLength' => $limit);
        return json_encode($result);
    }
}