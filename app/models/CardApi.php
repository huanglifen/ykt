<?php namespace App\Model;

use App\Utils\Utils;
use App\Utils\HttpClient;
use Illuminate\Support\Facades\Config;

/**
 * 一卡通前置平台
 * 消费：Order.aspx
充值：Recharge.aspx
签到：SignIn.aspx
查询订单状态：Query.aspx
查询余额：Balance.aspx
查询交易记录：TransactionRecords.aspx
验证卡的合法性：CheckCard.aspx
获取处理批次号：GetSysNum.aspx
 * @author heypigg
 */
class CardApi {
    var $api_url;
    var $account;
    var $pwd;
    var $work_key; //工作秘钥
    var $inputCharset = 'utf-8';
    var $version      = 'v1.0';
    var $language     = 1;
    var $signType     = 0; //MD5
    var $currencyType = 1; //RMB
    var $returnFormat = 1; //0xml 1json
    var $header       = array();
    var $header1      = array();
    var $footer       = array();
    var $platformId   = 2;
    var $orderTimeOut = 120;
    var $pageUrl;
    var $notifyUrl;
    var $errorNo      = array(0    => '初始状态', 1000 => '成功', 4    => '调用函数出错或卡状态有误', 5    => '钱包卡不能交易', 6    => '超限', 7    => '金额不正确', 8    => '余额不足', 9    => '非记名卡充值超1000',
        10   => '记名卡充值超5000', 14   => '无效的卡号', 55   => '密码错误', 1001 => '签名不正确', 1002 => 'code不存在或者已失效', 1003 => '码已失效或者本地时间不正确', 1004 => '用户不存在', 1005 => '未绑定任何一卡通', 1006 => '字段验证错误', 1007 => '卡池没有合适的卡数据', 1008 => '卡被其他用户绑定', 1009 => '以前卡绑定未解除', 1100 => '其他错误');

    public function __construct($notifyUrl = '', $pageUrl = '') {
        $this->api_url    = Config::get("param.merchant.api_url");
        $this->account    = Config::get('param.merchant.account');
        $this->pwd        = Config::get('param.merchant.pwd');
        $this->work_key   = Config::get('param.merchant.work_key');
        $this->platformId = Config::get('param.merchant.platformId');
        $this->pageUrl    = $pageUrl;
        $this->notifyUrl  = $notifyUrl;
        $this->header     = array('inputCharset' => $this->inputCharset, 'version' => $this->version, 'language' => $this->language, 'signType' => $this->signType, 'merchantAcctId' => $this->account);
        $this->header1    = array('inputCharset' => $this->inputCharset, 'pageUrl' => $this->pageUrl, 'notifyUrl' => $this->notifyUrl, 'version' => $this->version, 'language' => $this->language, 'signType' => $this->signType, 'merchantAcctId' => $this->account);
    }

    /**
     * 获取余额,单位是分
     *
     * @param $cardno
     * @param $checkcode
     * @return mixed
     */
    public function getBalance($cardno, $checkcode) {
        $result = $this->checkBalance($cardno, $checkcode);
        return Utils::transMoney($result->balance);
    }

    /**
     * 获取余额,单位是分
     *
     * @param $cardno
     * @param $checkcode
     * @return mixed
     */
    public function checkBalance($cardno, $checkcode) {
        $data                  = array();
        $data['cardNum']       = $cardno;
        $data['cardPassword']  = '';
        $data['cardVerifCode'] = $checkcode;
        $data['terminalTag']   = '';
        $data['currencyType']  = $this->currencyType;
        $data['getSysNum']     = 0;
        $data['returnFormat']  = $this->returnFormat;
        $result                = json_decode($this->post('Balance', $data));
        return $result;
    }

    //检查卡是否合法
    public function checkCard($cardno, $checkcode) {
        $data                  = array();
        $data['cardNum']       = $cardno;
        $data['cardVerifCode'] = $checkcode;
        $data['currencyType']  = $this->currencyType;
        $data['returnFormat']  = $this->returnFormat;
        $result                = $this->post('CheckCard', $data);
        return $result;
    }

    /**
     * post请求
     *
     * @param $type
     * @param $data
     * @param string $header
     * @return mixed
     */
    public function post($type, $data, $header = 'header') {
        $url         = $this->api_url . '/' . $type . '.aspx';
        $data        = array_merge($this->$header, $data);
        $signResult  = $this->sign($data);
        $data_string = $signResult['data_string'];
        $result      = HttpClient::quickPost($url, $data_string);

        return $result;
    }

    /**
     * pos签名
     *
     * @param $code
     * @param $timestamp
     * @return string
     */
    public function signature($code, $timestamp) {
        $token  = Config::get('params.merchant.pos_token');
        $tmpArr = array($token, $timestamp, $code);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        return $tmpStr;
    }

    public function checkSignature($signature, $timestamp, $openid) {
        $token  = Config::get('param.merchant.pos_token');
        $tmpArr = array($token, $timestamp, $openid);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * 加密
     *
     * @param $data
     * @return array
     */
    public function sign($data) {
        $result      = array();
        $data_string = '';
        foreach ($data as $key => $val) {
            $data_string.=$key . '=' . $val . '&';
        }
        $data_string           = substr($data_string, 0, -1);
        $result['signMsg']     = strtolower(md5(strtolower(md5(strtolower($data_string)) . $this->work_key)));
        $result['data_string'] = $data_string . '&signMsg=' . $result['signMsg'];
        return $result;
    }
}
