<?php namespace App\Module;

use App\Model\Card;
use App\Model\CardApi;
use App\Model\Customer;
use App\Model\PayCode;

class PayCodeModule extends BaseModule {
    const ERROR_USER_NOT_EXIST = 1001;
    const ERROR_NOT_BIND_CARD = 1002;
    const EXPIRE_TIME = 120;
    const ERROR_CODE_NOT_EXIST = 1002;
    const ERROR_CODE_EXPIRED = 1003;
    const SUCCESS = 1000;
    const ERROR_SIGNATURE = 1001;

    /**
     * 生成token
     *
     * @param $openid
     * @param int $type
     * @return array
     */
    public static function generateCode($openid,$type=0) {
        $customer = new Customer();
        $customer = $customer->where('openid', $openid)->first();
        if(empty($customer)) {
            return array('status' => false, 'errorCode' => self::ERROR_USER_NOT_EXIST, 'msg' => 'error_user_not_exist');
        }
        if(! $customer->cardid) {
            return array('status' => false, 'errorCode' => self::ERROR_NOT_BIND_CARD, 'msg' => 'error_not_bind_card');
        }

        $card = Card::find($customer->cardid);
        $cardApi = new CardApi();
        $balance = $cardApi->getBalance($card->cardno, $card->checkcode);
        $payCode = PayCode::where('uid', $customer->id)->where('cardid', $customer->cardid)->where('orderid', 0)->first();
        $code = Utils::createRandNumberBySize(18);
        $now = time();

        if(empty($payCode)) {
            $payCode = new PayCode();
            $payCode->uid = $customer->id;
            $payCode->cardid = $customer->cardid;
            $payCode->orderid = 0;
        }
        $payCode->from_type = $type;
        $payCode->token = $code;
        $payCode->expire = $now + self::EXPIRE_TIME;
        $payCode->create_time = $now;
        $payCode->save();

        $result = array();
        $result['status']  = TRUE;
        $result['errorCode']=1000;
        $result['code']    = $code;
        $result['id']      = $payCode->id;
        $result['uid']      = $customer['id'];
        $data['cardno']  = $card['cardno'];
        $data['balance'] = $balance;
        return $result;
    }

    /**
     * 检查pos回调签名
     *
     * @param $signature
     * @param $timestamp
     * @param $openid
     * @return bool
     */
    public static function checkPosSignature($signature, $timestamp, $openid) {
        $cardApi = new CardApi();
        $check = $cardApi->checkSignature($signature, $timestamp, $openid);
        return $check;
    }

    /**
     * 检查虚拟码，正确则返回卡号
     *
     * @param $code
     * @return array
     */
    public static function getCardNoByToken($code) {
        $time = time();
        $code = PayCode::where('token', $code)->leftJoin('card', 'card.id', '=', 'pay_code.cardid')->first();
        if(empty($code)) {
            return array('errorCode' => self::ERROR_CODE_NOT_EXIST);
        }
        if($code->expire < $time) {
            return array('errorCode' => self::ERROR_CODE_EXPIRED);
        }

        return array('errorCode' => self::SUCCESS, 'cardno' => $code->cardno);
    }

    /**
     * 按条件获取虚拟码
     *
     * @param $keyword
     * @param $offset
     * @param $limit
     * @return array|mixed
     */
    public static function getPayCodes($keyword, $offset, $limit) {
        $codes = new PayCode();
        $cardno = CardModule::encrypt($keyword, "E");
        $results = $codes->getPayCodes($keyword, $cardno, $offset, $limit);
        $results = CardModule::decodeCardNo($results);
        return $results;
    }

    /**
     * 按条件统计虚拟码
     *
     * @param $keyword
     * @return mixed
     */
    public static function countPayCodes($keyword) {
        $codes = new PayCode();
        $cardno = CardModule::encrypt($keyword, "E");
        $results = $codes->countPayCodes($keyword, $cardno);
        return $results;
    }
}