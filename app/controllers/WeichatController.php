<?php namespace App\Controllers;

use App\Utils\Utils;

/**
 * 微信服务接口控制器
 *
 * @package App\Controllers
 */
class WeichatController extends BaseController {
    public function getIndex() {
        $signature = $this->getParam('signature', 'required');
        $timestamp = $this->getParam('timestamp', 'required');
        $nonce = $this->getParam('nonce', 'required');
        $echostr = $this->getParam('echostr', 'required');

        $this->outputErrorIfExist();
        $result = Utils::checkSignature($signature, $timestamp, $nonce);
        if($result) {
            echo $echostr;
        }else {
            echo 'fail';
        }
    }
}