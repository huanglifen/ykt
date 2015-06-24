<?php namespace App\Module;
use App\Model\Card;
use App\Model\CardType;
use Illuminate\Support\Facades\DB;

/**
 * 卡片module层
 * @package App\Module
 */
class CardModule extends BaseModule {
    //卡状态
    public static $status = array(
        1 => '待分配',
        2 => '锁定',
        3 => '已分配'
    );

    //卡类别
    public static $type = array(
        0 => '虚拟卡',
        1 => '实体卡'
    );

    /**
     * 增加一张卡
     *
     * @param $cardNo
     * @param $checkCode
     * @param $cardType
     * @param $type
     * @param $status
     * @return array
     */
    public static function addCard($cardNo, $checkCode, $cardType, $type, $status) {
        $card = new Card();
        $card->cardno = self::encrypt($cardNo, "E");
        $card->card_type = $cardType;
        $card->checkcode = self::encrypt($checkCode, "E");
        $card->type = $type;
        $card->status = $status;

        $card->save();
        return array('status' => true, 'id' => $card->id);
    }

    /**
     * 删除一张卡
     *
     * @param $id
     * @return array
     */
    public static function deleteCard($id) {
        Card::destroy($id);
        return array('status' => true);
    }

    /**
     * 按主键更新卡
     *
     * @param $id
     * @param $cardNo
     * @param $checkCode
     * @param $cardType
     * @param $type
     * @param $status
     * @return array
     */
    public static function updateCardById($id, $cardNo, $checkCode, $cardType, $type, $status) {
        $card = Card::find($id);
        if(empty($card)) {
            return array('status' => false, 'msg' => 'error_card_not_exits');
        }
        $card->cardno = self::encrypt($cardNo, "E");
        $card->checkcode = self::encrypt($checkCode, "E");
        $card->card_type = $cardType;
        $card->type = $type;
        $card->status = $status;

        $card->update();
        return array('status' => true, 'id' => $card->id);
    }

    /**
     * 按主键获取卡信息
     *
     * @param $id
     * @return \Illuminate\Support\Collection|null|static
     */
    public static function getCardById($id) {
        return Card::find($id);
    }

    /**
     * 按条件获取卡
     *
     * @param int $cardType 卡类型
     * @param int $type 卡类别
     * @param int $status
     * @param int $offset
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getCards($cardType = 0, $type = -1, $status = 0, $offset = 0, $limit= self::NUM_PER_PAGE) {
        $card = new Card();
        $card = $card->leftJoin("card_type", "card_type.id", "=", "card.card_type");
        if($cardType) {
            $card = $card->where('card_type', $cardType);
        }
        if($type > -1) {
            $card = $card->where('type', $type);
        }
        if($status) {
            $card = $card->where('status', $status);
        }
        if($limit) {
            $card = $card->offset($offset)->limit($limit);
        }
        $card->selectRaw("card.*,ifnull(card_type.name,'无') as cardtypename");
        $card =  $card->get();
        return $card;
    }

    /**
     * 按条件统计卡记录
     *
     * @param int $cardType
     * @param int $type
     * @param int $status
     * @return int
     */
    public static function countCards($cardType = 0, $type=0, $status = 0) {
        $card = new Card();
        if($cardType) {
            $card = $card->where('card_type', $cardType);
        }
        if($type > -1) {
            $card = $card->where('type', $type);
        }
        if($status) {
            $card = $card->where('status', $status);
        }
        return $card->count();
    }

    /**
     * 按卡类型统计卡数
     *
     * @param $cardType
     * @return int
     */
    public static function countCardByCardType($cardType) {
        return Card::where('card_type', $cardType)->count();
    }

    /**
     * 解析卡数据
     *
     * @param $cards
     * @return mixed
     */
    public static function decodeCards(&$cards) {
        foreach($cards as &$card) {
            $card->cardno = self::encrypt($card->cardno, "D");
            $card->checkcode = self::encrypt($card->checkcode, "D");
        }
        return $cards;
    }
}