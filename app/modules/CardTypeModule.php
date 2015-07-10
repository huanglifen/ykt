<?php namespace App\Module;
use App\Model\CardType;

/**
 * 卡片类型module层
 * @package App\Module
 */
class CardTypeModule extends BaseModule {
    public static $type = array(
        1 => '允许绑定',
        2 => '允许申请',
        3 => '允许销售'
    );

    /**
     * 添加卡类型
     *
     * @param $name
     * @param $type
     * @param $sort
     * @return array
     */
    public static function addCardType($name, $type, $sort) {
        $cardType = new CardType();

        $cardType->name = $name;
        $cardType->type = $type;
        $cardType->sort = $sort;
        $cardType->save();
        return array("status" => true, "id" => $cardType->id);
    }

    /**
     * 删除卡类型
     *
     * @param $id
     * @return array
     */
    public static function deleteCardTypeById($id) {
        $count = CardModule::countCardByCardType($id);
        if($count) {
            return array('status' => false, 'msg' => 'error_has_card_belong_to_this_cardtype');
        }
        CardType::destroy($id);
        return array('status' => true, 'id' => $id);
    }

    public static function updateCardType($id, $name, $type, $sort) {
        $cardType = self::getCardTypeById($id);

        $cardType->name = $name;
        $cardType->type = $type;
        $cardType->sort = $sort;
        $cardType->update();

        return array('status' => true, 'id' => $cardType->id);
    }

    /**
     * 按位移、限制量获取类型记录
     *
     * @param $offset
     * @param $limit
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getCardType($offset, $limit) {
        $cardType = new CardType();
        if($limit > 0) {
            $cardType->offset($offset)->limit($limit);
        }
        return $cardType->get();
    }

    /**
     * 统计类型总数
     *
     * @return int
     */
    public static function countCardType() {
        return CardType::count();
    }

    /**
     * 按主键获取卡类型
     *
     * @param $id
     * @return \Illuminate\Support\Collection|null|static
     */
    public static function getCardTypeById($id) {
        return CardType::find($id);
    }
}