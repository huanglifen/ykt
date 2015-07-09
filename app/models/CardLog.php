<?php namespace App\Model;

/**
 * 卡片日志
 *
 * @package App\Model
 */
class CardLog extends \Eloquent {
    protected $table="card_log";
    protected $customerTable = "customer";

    /**
     * 按卡主键获取卡记录
     *
     * @param $cardId
     * @param $offset
     * @param $limit
     * @return array
     */
    public function getCardLog($cardId, $offset, $limit) {
        $sql = "select a.*, b.username as username from $this->table a ";
        $sql .= "left join $this->customerTable b on b.id = a.uid ";
        $sql .= "where a.cardid = $cardId ";

        if($limit) {
            $sql .= "limit $offset, $limit";
        }
        return \DB::select($sql);
    }
}