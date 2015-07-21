<?php namespace App\Model;

use App\Utils\HttpClient;

class WeixinApi {
    /**
     * 微信验证签名
     *
     * @param $signature
     * @param $timestamp
     * @param $nonce
     * @return bool
     */
    public function checkSignature($signature, $timestamp, $nonce) {
        $token = \Config::get('param.weixin.token');
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 获取微信access_token
     * @return mixed
     */
    public function getTokenAccess() {
        $appId = \Config::get('param.weixin.app_id');
        $secret = \Config::get('param.weixin.app_secret');
        $url = \Config::get('param.weixin.weixin_url');
        $accessUrl = $url . "token?grant_type=client_credential";
        $accessUrl .="&appid=$appId&secret=$secret";
        $result = HttpClient::quickGet($accessUrl);
        return $result;
    }

    /**
     * 更新菜单到微信
     *
     * @param $menus
     * @return mixed
     */
    public function syncMenu($menus) {
        $accessToken = $this->getTokenAccess();

        $url = \Config::get('param.weixin.weixin_url');
        $url = $url . "menu/create?access_token=" . $accessToken;
        $result        = HttpClient::quickPost($url, $menus);
        return $result;
    }
}