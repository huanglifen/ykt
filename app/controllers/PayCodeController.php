<?php namespace App\Controllers;

use App\Module\PayCodeModule;

class PayCodeController extends BaseController {

    public function getIndex() {
        $isLogin = $this->isLogin();

        if(! $isLogin){
            return \Redirect::to('/login');
        }

        return $this->showView('card.paycode');
    }

    public function getCodes() {
        $this->outputUserNotLogin();

        $keyword = $this->getParam('keyword');
        $offset = $this->getParam('iDisplayStart');
        $limit = $this->getParam('iDisplayLength');
        $limit = $limit ? $limit : PayCodeModule::NUM_PER_PAGE;

        $this->outputErrorIfExist();

        $codes = PayCodeModule::getPayCodes($keyword, $offset, $limit);
        $total = PayCodeModule::countPayCodes($keyword);
        $result = array('codes' => $codes, 'iTotalDisplayRecords' => $total, '_iRecordsTotal' => $total, 'iDisplayStart' => $offset, 'iDisplayLength' => $limit);

        return json_encode($result);
    }
}