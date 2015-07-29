<?php namespace App\Controllers;

use App\Module\CardTypeModule;
use App\Module\PaySetModule;
use Illuminate\Support\Facades\Redirect;

/**
 * 缴费业务设置控制器
 *
 * @package App\Controllers
 */
class PaySetController extends BaseController {

    public $viewArr = array(
        PaySetModule::CATEGORY_MOBILE => 'mobile',
        PaySetModule::CATEGORY_GAS => 'gas',
        PaySetModule::CATEGORY_INSURANCE => 'insurance',
        PaySetModule::CATEGORY_TV => 'tv'
    );

    /**
     * 显示充值设置管理页面
     *
     * @param int $category
     * @return mixed
     */
    public function getIndex($category = PaySetModule::CATEGORY_MOBILE) {
        if(! $this->isLogin()) {
            return Redirect::to("/login");
        }
        $cardType = CardTypeModule::getCardType(0, -1);

        if($category == PaySetModule::CATEGORY_MOBILE) {
            $mobile = PaySetModule::getPaySetting(PaySetModule::CATEGORY_MOBILE, PaySetModule::TYPE_MOBILE);
            $unicom = PaySetModule::getPaySetting(PaySetModule::CATEGORY_MOBILE, PaySetModule::TYPE_UNICOM);
            $telcom = PaySetModule::getPaySetting(PaySetModule::CATEGORY_MOBILE, PaySetModule::TYPE_TELECOM);
            $this->data = compact('mobile', 'cardType', 'unicom', 'telcom');
        } else {
            $paySet = PaySetModule::getPaySetting($category);
            $this->data = compact("cardType", 'paySet');
        }
        $view = $this->viewArr[$category];
        return $this->showView("pay.$view");
    }

    /**
     * 设置充值业务
     *
     * @return string
     */
    public function postUpdate() {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required');
        $name = $this->getParam('name', 'required');
        $category = $this->getParam('category', 'required');
        $type = $this->getParam('type', 'required');
        $supportCard = $this->getParam('supportCard', 'required');
        $supportMoney = $this->getParam('supportMoney', 'required');

        $this->outputErrorIfExist();

        $result = PaySetModule::updateSetting($id, $name, $category, $type, $supportCard, $supportMoney);
        $this->outputErrorIfFail($result);

        return $this->outputContent($result);
    }

    /**
     * 更新业务设置状态请求
     *
     * @return string
     */
    public function postStatus() {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required');
        $this->outputErrorIfExist();

        $result = PaySetModule::updateStatus($id);
        $this->outputErrorIfFail($result);
        return $this->outputContent($result);
    }

    /**
     * 更新支持的金额请求
     *
     * @return string
     */
    public function postMoney() {
        $this->outputUserNotLogin();

        $money = $this->getParam('money');
        $id = $this->getParam('id', 'required');
        $this->outputErrorIfExist();

        $result = PaySetModule::updateMoney($id, $money);
        $this->outputErrorIfFail($result);
        return $this->outputContent($result);
    }

    /**
     * 修改支持的卡类型请求
     *
     * @return string
     */
    public function postCardType() {
        $this->outputUserNotLogin();

        $cardType = $this->getParam('cardType');
        $id = $this->getParam('id', 'required');
        $this->outputErrorIfExist();

        $result = PaySetModule::updateCardType($id, $cardType);
        $this->outputErrorIfFail($result);
        return $this->outputContent($result);
    }

}