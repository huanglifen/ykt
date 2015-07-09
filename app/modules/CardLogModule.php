<?php namespace App\Module;

use App\Model\CardLog;
use App\Model\Customer;

class CardLogModule extends  BaseModule {
    public static $type =
        array(
            0 => '申请',
            1 => '绑定',
            2 => '解绑'
        );

    /**
     * 获取卡片操作记录
     *
     * @param $cardId
     * @param $offset
     * @param $limit
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getCardLog($cardId, $offset, $limit) {
        $logs = new CardLog();
        return $logs->getCardLog($cardId, $offset, $limit);
    }
}

