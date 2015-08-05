<?php namespace App\Controllers;

use App\Module\SaleCardModule;

/**
 * 在线售卡控制器
 *
 * @package App\Controllers
 */
class SaleCardController extends BaseController {

    public $dateArr = array(
        0 => '全部',
        1 => '今天',
        2 => '一个月',
        3 => '三个月'
    );

    //关键信息
    public $keywordArr = array(
        1 => '订单编号',
        2 => '客户名称',
        3 => '卡号',
        4 => '联系电话'
    );

    //交易状态
    public $statusArr = array (
        0 => '全部',
        SaleCardModule::STATUS_SUBMIT => '已提交',
        SaleCardModule::STATUS_DEALING => '处理中',
        SaleCardModule::STATUS_SUCCESS => '交易成功',
        SaleCardModule::STATUS_FAIL => '交易失败'
    );

    //邮寄状态
    public $postStatusArr = array(
        0 => '全部',
        SaleCardModule::POST_STATUS_NON_DELIVERY => '处理中',
        SaleCardModule::POST_STATUS_DELIVERY => '已发货',
        SaleCardModule::POST_STATUS_RECEIVED => '已收件'
    );

    /**
     * 显示在线售卡页面
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getIndex() {
        if(! $this->isLogin()) {
            return \Redirect::to("/login");
        }
        $keyword = $this->keywordArr;
        $date = $this->dateArr;
        $status = $this->statusArr;
        $postStatus = $this->postStatusArr;
        $this->data = compact('keyword', 'date', 'status', 'postStatus');
        return $this->showView("recharge.sale-card");
    }

    /**
     * 获取在线售卡请求
     *
     * @return string
     */
    public function getSale() {
        $this->outputUserNotLogin();

        $offset = $this->getParam('iDisplayStart');
        $limit = $this->getParam('iDisplayLength');
        $startTime = $this->getParam('startTime');
        $endTime = $this->getParam('endTime');
        $keyword = $this->getParam('keyword');
        $type = $this->getParam('type');
        $status = $this->getParam('status');
        $minMount = $this->getParam('minMount');
        $maxMount = $this->getParam('maxMount');
        $date = $this->getParam('date');
        $postStatus = $this->getParam('postStatus');

        $this->outputErrorIfExist();
        $cardNo = '';
        $orderNo = '';
        $tel = '';
        $customerName = '';
        if($type == 1) {
            $orderNo = $keyword;
        } elseif ($type == 2) {
            $customerName = $keyword;
        } elseif ($type == 3) {
            $cardNo = $keyword;
        } elseif ($type == 4) {
            $tel = $keyword;
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

        $saleCards = SaleCardModule::getSaleCards($startTime, $endTime, $status, $orderNo, $customerName, $cardNo, $tel, $postStatus, $minMount, $maxMount);
        $total = SaleCardModule::countSaleCards($startTime, $endTime, $status, $orderNo, $customerName, $cardNo, $tel, $postStatus, $minMount, $maxMount);

        $result = array('salecards' => $saleCards, 'iTotalDisplayRecords' => $total, '_iRecordsTotal' => $total, 'iDisplayStart' => $offset, 'iDisplayLength' => $limit);
        return json_encode($result);

    }
}