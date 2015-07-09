<?php namespace App\Controllers;

use App\Module\CardModule;
use App\Module\CardTypeModule;
use App\Module\CustomerModule;

/**
 * 客户控制器
 *
 * @package App\Controllers
 */
class CustomerController extends BaseController {

    /**
     * 客户管理首页
     * @return \Illuminate\View\View
     */
    public function getIndex() {
        $type = CardModule::$type;
        $cardType = CardTypeModule::getCardType(0, -1);
        $this->data = compact('type', 'cardType');
        return $this->showView('card.customer');
    }

    /**
     * 获取客户请求
     */
    public function getCustomers() {
        $this->outputUserNotLogin();

        $bind = $this->getParam('bind');
        $type = $this->getParam('type');
        $offset = $this->getParam('iDisplayStart');
        $limit = $this->getParam('iDisplayLength');
        $keyword = $this->getParam('keyword');
        $this->outputErrorIfExist();

        if($type === null) {
            $type = -1;
        }
        $customers = CustomerModule::getCustomers($bind, $type, $keyword, $offset, $limit);
        $total = CustomerModule::countCustomers($bind, $type, $keyword, $offset, $limit);
        $result = array('customers' => $customers, 'iTotalDisplayRecords' => $total, '_iRecordsTotal' => $total, 'iDisplayStart' => $offset, 'iDisplayLength' => $limit);

        return json_encode($result);
    }

    /**
     * 获取一个用户信息请求
     *
     * @return string
     */
    public function getCustomer() {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required|numeric');
        $this->outputErrorIfExist();

        $customer = CustomerModule::getCustomerById($id);
        return $this->outputContent($customer);
    }

    /**
     *
     */
    public function postBindCard() {
        $cardType = $this->getParam('cardType', 'rquired');
        $cardNo = $this->getParam('cardNo', 'required');
        $checkCode = $this->getParam('checkCode', 'required');
        $customerId = $this->getParam('customerId', 'required');

        $this->outputErrorIfExist();

        $result = CardModule::bindCard($cardNo, $checkCode, $customerId, $cardType);
        $this->outputErrorIfFail($result);
        return $this->outputContent($result);
    }
}