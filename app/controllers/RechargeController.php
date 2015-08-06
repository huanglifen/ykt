<?php namespace App\Controllers;

use App\Module\RechargeModule;
use Illuminate\Support\Facades\Redirect;

/**
 * 充值控制器
 *
 * @package App\Controllers
 */
class RechargeController extends BaseController {
    public $dateArr = array(
        0 => '全部',
        1 => '今天',
        2 => '一个月',
        3 => '三个月'
    );

    //关键信息
    public $keywordArr = array(
        1 => '订单编号',
        2 => '交易号',
        3 => '交易账号',
    );

    //交易状态
    public $statusArr = array (
        0 => '全部',
        RechargeModule::STATUS_NOT_PAYED => '未支付',
        RechargeModule::STATUS_SUCCESS => '交易成功',
        RechargeModule::STATUS_FAIL => '交易失败'
    );

    //交易类型
    public $tradeType = array(
        0 => '全部',
        1 => '充值'
    );

    //支付类型
    public $payType = array(
        0 => '全部',
        RechargeModule::PAY_TYPE_WEIXIN => '微信支付',
        RechargeModule::PAY_TYPE_ALIPAY => '支付宝',
        RechargeModule::PAY_TYPE_UNION => '银联'
    );

    //商户名称
    public $businessName = array(
        1 => '一卡通APP',
        2 => '微信公众号',
        3 => '一卡通网站'
    );

    /**
     * 显示充值查询页面
     *
     * @return \Illuminate\View\View
     */
    public function getIndex() {
        if(! $this->isLogin()) {
            return Redirect::to("/login");
        }
        $status = $this->statusArr;
        $keyword = $this->keywordArr;
        $date = $this->dateArr;
        $tradeType = $this->tradeType;
        $payType = $this->payType;
        $businessName = $this->businessName;
        $this->data = compact("status", "keyword", "date", 'tradeType', 'payType', 'businessName');
        return $this->showView('recharge.recharge-search');
    }

    /**
     * 按条件显示充值记录
     *
     * @return string
     */
    public function getRecharge() {
        $this->outputUserNotLogin();

        $offset = $this->getParam('iDisplayStart');
        $limit = $this->getParam('iDisplayLength');
        $startTime = $this->getParam('startTime');
        $endTime = $this->getParam('endTime');
        $keyword = $this->getParam('keyword');
        $status = $this->getParam('status');
        $minMount = $this->getParam('minMount');
        $maxMount = $this->getParam('maxMount');
        $date = $this->getParam('date');
        $tradeType = $this->getParam('tradeType');
        $type = $this->getParam('type');

        $this->outputErrorIfExist();

        $cardNo = '';
        $orderNo = '';
        $tradeNo = '';
        if($type == 1) {
            $orderNo = $keyword;
        } elseif ($type == 2) {
            $tradeNo = $keyword;
        } elseif ($type == 3) {
            $cardNo = $keyword;
        }

        if($date != 0) {
            $now = time();
            $endTime = date("Y-m-d H:i:s", strtotime("tomorrow")-1);
            switch($date) {
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

        $recharge = RechargeModule::getRecharges($startTime, $endTime, $status, $orderNo, $tradeNo, $cardNo, $tradeType, $minMount, $maxMount);
        $total = RechargeModule::countRecharges($startTime, $endTime, $status, $orderNo, $tradeNo, $cardNo, $tradeType, $minMount, $maxMount);

        $result = array('recharge' => $recharge, 'iTotalDisplayRecords' => $total, '_iRecordsTotal' => $total, 'iDisplayStart' => $offset, 'iDisplayLength' => $limit);
        return json_encode($result);
    }
}