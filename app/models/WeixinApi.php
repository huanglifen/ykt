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
        $accessUrl = \Config::get('param.weixin.token_access_url');
        $accessUrl .="&appid=$appId&secret=$secret";
        $result = HttpClient::quickGet($accessUrl);
        return $result;
    }
}