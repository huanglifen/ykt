<?php namespace App\Module;

use App\Model\PaySet;

class PaySetModule extends BaseModule {
    const CATEGORY_MOBILE = 1; //话费
    const CATEGORY_GAS = 2; //燃气
    const CATEGORY_INSURANCE = 3; //保险
    const CATEGORY_TV = 4; //有线电视
    const CATEGORY_YKT = 5; //一卡通充值
    const TYPE_MOBILE = 1; //移动
    const TYPE_UNICOM = 2; //联通
    const TYPE_TELECOM = 3; //电信
    const TYPE_INSURANCE = 4; //保险公司
    const TYPE_GAS = 5; //燃气公司
    const TYPE_TV = 6; //有线电视
    public static $typeArr = array(
        self::TYPE_MOBILE => '中国移动',
        self::TYPE_UNICOM => '中国联通',
        self::TYPE_TELECOM => '中国电信',
        self::TYPE_INSURANCE => '保险公司',
        self::TYPE_TV => '有线电视',
        self::TYPE_GAS => '燃气公司'
    );

    /**
     * 更新业务设置状态
     *
     * @param $id
     * @return array
     */
    public static function updateStatus($id) {
        $pay = PaySet::find($id);
        if(empty($pay)) {
            return array('status' => false, 'id' => 'error_id_not_exist');
        }
        if($pay->status == self::STATUS_OPEN) {
            $pay->status = self::STATUS_CLOSE;
        }else{
            $pay->status = self::STATUS_OPEN;
        }
        $pay->save();
        return array('status' => true, 'state' => $pay->status);
    }

    /**
     * 修改支持的充值金额
     *
     * @param $id
     * @param $money 10,20, 以,格式分隔
     * @return array
     */
    public static function updateMoney($id, $money) {
        $pay = PaySet::find($id);
        if(empty($pay)) {
            return array('status' => false, 'id' => 'error_id_not_exist');
        }
        $pay->support_money = $money;
        $pay->save();
        return array('status' => true);
    }

    /**
     * 修改支持的卡类型
     *
     * @param $id
     * @param $cardType 1,2 以,格式分隔
     * @return array
     */
    public static function updateCardType($id, $cardType) {

        $pay = PaySet::find($id);
        if(empty($pay)) {
            return array('status' => false, 'id' => 'error_id_not_exist');
        }
        $pay->support_card = $cardType;
        $pay->save();
        return array('status' => true);
    }

    /**
     * 按类别获取业务设置
     *
     * @param $category
     * @param $type
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getPaySetting($category, $type = 0) {
        $paySet = PaySet::where('category', $category);
        if($type) {
            $paySet = $paySet->where('type', $type);
        }
        $paySet =  $paySet->first();
        if(empty($paySet)) {
            $paySet = new PaySet();
            $paySet->name = '';
            $paySet->category = $category;
            $paySet->type = $type;
            $paySet->support_card = "";
            $paySet->support_money = "";
            $paySet->status = self::STATUS_OPEN;
            $paySet->save();
        }
        return $paySet;
    }

}