<?php namespace App\Controllers;

use App\Module\ExchangeModule;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

/**
 * 交易控制器
 *
 * @package App\Controllers
 */
class ExchangeController extends BaseController {
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
        ExchangeModule::STATUS_NOT_PAYED => '未支付',
        ExchangeModule::STATUS_SUCCESS => '交易成功',
        ExchangeModule::STATUS_FAIL => '交易失败'
    );

    //交易类型
    public $tradeType = array(
        0 => '全部',
        ExchangeModule::TYPE_RECHARGE => '充值',
        ExchangeModule::TYPE_PAYMENT => '消费'
    );

    //支付类型
    public $payType = array(
        0 => '全部',
        ExchangeModule::PAY_TYPE_WEIXIN => '微信支付',
        ExchangeModule::PAY_TYPE_ALIPAY => '支付宝',
        ExchangeModule::PAY_TYPE_UNION => '银联'
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
     * @param int $tradeTyp
     * @return \Illuminate\View\View
     */
    public function getIndex($tradeTyp = 0) {
        if(! $this->isLogin()) {
            return Redirect::to("/login");
        }
        $status = $this->statusArr;
        $keyword = $this->keywordArr;
        $date = $this->dateArr;
        $tradeTypes = $this->tradeType;
        $payType = $this->payType;
        $businessName = $this->businessName;
        $this->data = compact("status", "keyword", "date", 'tradeTypes', 'payType', 'businessName', 'tradeTyp');
        return $this->showView('recharge.exchange-search');
    }

    /**
     * 按条件显示交易记录
     *
     * @return string
     */
    public function getExchange() {
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
        $type = $this->getParam('type');
        $tradeType = $this->getParam('tradeType');

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

        $exchange = ExchangeModule::getExchanges($startTime, $endTime, $status, $orderNo, $tradeNo, $cardNo, $tradeType, $minMount, $maxMount, $offset, $limit);
        $total = ExchangeModule::countExchanges($startTime, $endTime, $status, $orderNo, $tradeNo, $cardNo, $tradeType, $minMount, $maxMount);

        $result = array('exchange' => $exchange, 'iTotalDisplayRecords' => $total, '_iRecordsTotal' => $total, 'iDisplayStart' => $offset, 'iDisplayLength' => $limit);
        return json_encode($result);
    }

    /**
     * 下载
     *
     * @param string $fileType
     * @return string
     */
    public function getDownload($fileType = 'xlsx') {
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
        $type = $this->getParam('type');
        $tradeType = $this->getParam('tradeType');

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

        $exchange = ExchangeModule::getExchanges($startTime, $endTime, $status, $orderNo, $tradeNo, $cardNo, $tradeType, $minMount, $maxMount, $offset, $limit);

        $result = array();
        $result[] = array("创建时间","商户名称","商户订单号","交易号","交易账号","支付方式","支付金额","交易类型","交易状态");

        foreach($exchange as $ex) {
            if($ex->type == ExchangeModule::TYPE_RECHARGE) {
                $businessName = $this->businessName[$ex->business_id];
            } else {
                $businessName = $ex->businessName;
            }
            $payType = $this->payType[$ex->pay_type];
            $exchangeType = $this->tradeType[$ex->type];
            $exchangeStatus = $this->statusArr[$ex->status];
            $result[] = array($ex->created_at, $businessName, $ex->order_no, $ex->trade_no, $ex->cardno, $payType, $ex->pay_mount, $exchangeType, $exchangeStatus);
        }
        $fileName = date("YmdHis");
        if($tradeType == 1) {
            $fileName .= "充值查询";
        }elseif($tradeType == 2){
            $fileName .= "消费查询";
        } else {
            $fileName .= "查询业务";
        }
        Excel::create($fileName, function($excel) use($result) {
            $excel->sheet('sheet1', function($sheet) use($result) {
                $sheet->fromArray($result, null, "A1", true, false);
                $sheet->setAutoSize(true);
                $sheet->setWidth(array(
                    'A' => 20,
                    'B' => 20,
                    'C' => 20,
                    'D' => 20,
                    'E' => 20,
                    'F' => 20,
                    'G' => 20,
                    'H' => 20,
                    'I' => 20,
                    'J' => 20,
                ));
                $sheet->cells('A1:I1', function($cells) {
                    $cells->setFontWeight('bold');
                });
            });
        })->export($fileType);
    }
}