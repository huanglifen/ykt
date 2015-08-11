<?php namespace App\Controllers;
use App\Module\PreferentialModule;
use App\Module\ExchangeModule;
use Maatwebsite\Excel\Facades\Excel;

/**
 * 充值、消费交易优惠
 *
 * @package App\Controllers
 */
class PreferentialController extends BaseController {
    //优惠对象
    public $target = array(
      0 => '全部'
    );

    //优惠来源
    public $source = array(
        0 => '全部',
        1 => '营销账户',
        2 => '次月返现'
    );

    //交易类型
    public $tradeType = array(
        1 => '充值',
        2 => '消费'
    );

    //支付类型
    public $payType = array(
        0 => '全部',
        ExchangeModule::PAY_TYPE_WEIXIN => '微信支付',
        ExchangeModule::PAY_TYPE_ALIPAY => '支付宝',
        ExchangeModule::PAY_TYPE_UNION => '银联'
    );

    //按优惠策略
    public $strategy = array(
        0 => '全部',
        1 => '按百分比',
        2 => '满减'
    );
    /**
     * 显示优惠页面
     *
     * @param $tradeTyp  1：充值 2：消费
     * @return \Illuminate\View\View
     */
    public function getIndex($tradeTyp = 0) {
        if(! $this->isLogin()) {
            return $this->showView('/login');
        }
        $target = $this->target;
        $strategy = $this->strategy;
        $source = $this->source;
        $tradeType = $this->tradeType;
        $payType = $this->payType;
        $this->data = compact("tradeTyp", 'target', 'strategy', 'source', 'tradeType', 'payType');
        return $this->showView('recharge.preferential');
    }

    /**
     * 按条件获取优惠记录
     *
     * @return string
     */
    public function getPreferential() {
        $this->outputUserNotLogin();

        $offset = $this->getParam('iDisplayStart');
        $limit = $this->getParam('iDisplayLength');
        $startTime = $this->getParam('startTime');
        $endTime = $this->getParam('endTime');
        $strategy = $this->getParam('strategy');
        $preferMount = $this->getParam('preferMount');
        $source = $this->getParam('source');
        $target = $this->getParam('target');
        $lowest = $this->getParam('lowest');
        $highest = $this->getParam('highest');
        $name = $this->getParam('name');
        $tradeType = $this->getParam('tradeType');

        $this->outputErrorIfExist();

        $startTime = $startTime ? date("Y-m-d", strtotime($startTime)) : '';
        $endTime = $endTime ? date("Y-m-d 23:59:59", strtotime($endTime)) : '';

        $preferential = PreferentialModule::getPreferential($strategy, $preferMount, $source, $startTime, $endTime, $target, $lowest, $highest, $name, $tradeType, $offset, $limit);
        $total = PreferentialModule::countPreferential($strategy, $preferMount, $source, $startTime, $endTime, $target, $lowest, $highest, $name, $tradeType);
        $result = array('preferential' => $preferential, 'iTotalDisplayRecords' => $total, '_iRecordsTotal' => $total, 'iDisplayStart' => $offset, 'iDisplayLength' => $limit);
        return json_encode($result);
    }

    /**
     * 按格式下载优惠记录
     *
     * @param string $fileType
     */
    public function getDownload($fileType = 'xlsx') {
        $this->outputUserNotLogin();

        $startTime = $this->getParam('startTime');
        $endTime = $this->getParam('endTime');
        $strategy = $this->getParam('strategy');
        $preferMount = $this->getParam('preferMount');
        $source = $this->getParam('source');
        $target = $this->getParam('target');
        $lowest = $this->getParam('lowest');
        $highest = $this->getParam('highest');
        $name = $this->getParam('name');
        $tradeType = $this->getParam('tradeType');

        $this->outputErrorIfExist();

        $startTime = $startTime ? date("Y-m-d", strtotime($startTime)) : '';
        $endTime = $endTime ? date("Y-m-d 23:59:59", strtotime($endTime)) : '';

        $preferential = PreferentialModule::getPreferential($strategy, $preferMount, $source, $startTime, $endTime, $target, $lowest, $highest, $name, $tradeType, 0, 65535);
        $result = array();
        $result[] = array("创建时间","创建人","活动名称","开始时间","结束时间","交易类型","支付方式","支付金额","优惠来源","优惠金额","总交易金额","最低限额","最高限额");
        foreach($preferential as $prefer) {
            $tradeTyp = $this->tradeType[$prefer->trade_type];
            $payType = $this->payType[$prefer->pay_type];
            $source = $this->source[$prefer->source];
            $result[] = array($prefer->created_at, $prefer->creator, $prefer->name, $prefer->start_time, $prefer->end_time, $tradeTyp, $payType, $prefer->pay_mouny, $source, $prefer->prefer_mount, $prefer->total_mount, $prefer->lowest_mount, $prefer->highest_mount);
        }

        $fileName = date("YmdHis");
        if($tradeType == 1) {
            $fileName .= "充值优惠";
        }elseif($tradeType == 2){
            $fileName .= "消费优惠";
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
                    'K' => 20,
                    'L' => 20,
                    'M' => 20,
                ));
                $sheet->cells('A1:M1', function($cells) {
                    $cells->setFontWeight('bold');
                });
            });
        })->export($fileType);
    }
}