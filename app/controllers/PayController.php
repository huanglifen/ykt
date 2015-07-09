<?php  namespace App\Controllers;

use App\Module\PayCodeModule;
use App\Utils\Utils;
use Illuminate\Support\Facades\Config;

/**
 * 支付控制器
 * 微信 、APP
 * @package App\Controllers
 */
class PayController extends BaseController {
    public $langFile = 'pay';

    /**
     * 生成二维码或者条形码API
     */
    public function getCreateCode() {
        $check = $this->checkSignature();
        if(! $check) {
            $result = array('status' => false, 'msg' => 'error_signature');
            $this->outputErrorIfFail($result);
        }
        $data = $this->getParam('data', 'required');
        $type = $this->getParam('type', 'required');

        $this->outputErrorIfExist();

        if($type == 'bar') {
            Utils::barCreate($data);
        }else{
            Utils::qrCreate($data);
        }
    }

    /**
     * 重新生成token码
     */
    public function getNewCode() {
        $check = $this->checkSignature();
        if(! $check) {
            $result = array('status' => false, 'msg' => 'error_signature');
            $this->outputErrorIfFail($result);
        }
        $openid  = $this->getParam('openid', 'required');

        $result = PayCodeModule::generateCode($openid);
        if ($result['status'] == TRUE) {
            $dourl = Utils::createUrlBySignature($openid, 'pay/do', array('data' => $result['code']));
            return \Redirect::to($dourl);
        }
    }

    /**
     * 展示二维码和条形码
     */
    public function getDo() {
        $check = $this->checkSignature();
        if(! $check) {
            $result = array('status' => false, 'msg' => 'error_signature');
            $this->outputErrorIfFail($result);
        }

        $code            = $this->getParam('data', 'required');
        $openid          = $this->getParam('openid', 'required');
        $this->outputErrorIfExist();

        $barurl          =  Utils::createUrlBySignature($openid, 'pay/create-code', array('type' => 'bar', 'data' => $code));
        $qrurl           =  Utils::createUrlBySignature($openid, 'pay/create-code', array('type' => 'qr', 'data' => $code));
        $repeatUrl       =  Utils::createUrlBySignature($openid, 'pay/new-code');
        $pageTitle = '付款码';
        $this->data = compact('barurl', 'qrurl', 'repeatUrl', 'pageTitle');
        return $this->showView('card.pay');
    }

    /**
     * 检查虚拟码请求
     */
    public function postCheckCode() {
        $code = $this->getParam('code', 'required');
        $timestamp = $this->getParam('timestamp', 'required');
        $sign = $this->getParam('signature', 'required');

        $this->outputErrorIfExist();
        $check = PayCodeModule::checkPosSignature($sign, $timestamp, $code);
        if(! $check) {
            $result = array('errorCode' => PayCodeModule::ERROR_SIGNATURE);
            echo json_encode($result);
        }

        $result = PayCodeModule::getCardNoByToken($code);
        echo json_encode($result);
    }

    /**
     * 微信端验证签名
     *
     * @return bool
     */
    private function checkSignature() {
        $signature = $this->getParam('signature', 'required');
        $timestamp = $this->getParam('timestamp', 'required');
        $openid = $this->getParam('openid', 'required');
        $token = Config::get('param.weixin.token_url');

        $this->outputErrorIfExist();

        $tmpArr    = array($token, $timestamp, $openid);
        sort($tmpArr, SORT_STRING);
        $tmpStr    = implode($tmpArr);
        $tmpStr    = sha1($tmpStr);
        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }
}