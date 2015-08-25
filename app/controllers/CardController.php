<?php namespace App\Controllers;

use App\Module\CardLogModule;
use App\Module\CardModule;
use App\Module\CardTypeModule;
use App\Module\LogModule;
use Illuminate\Support\Facades\Redirect;

/**
 * 卡片控制器
 *
 * @package App\Controllers
 */
class CardController extends  BaseController{
    protected $langFile = 'card';

    /**
     * 显示卡页面
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getIndex() {
        if(! $this->isLogin()) {
            return \Redirect::to("/login");
        }

        $cardType = CardTypeModule::getCardType(0, -1);
        $status = CardModule::$status;
        $type = CardModule::$type;
        $this->data = compact('cardType', 'type', 'status');
        return $this->showView('card.card');
    }

    /**
     * 获取卡请求
     *
     * @return string
     */
    public function getCards() {
        $this->outputUserNotLogin();

        $cardType = $this->getParam('cardType');
        $type = $this->getParam('type');
        $status = $this->getParam('status');
        $offset = $this->getParam('iDisplayStart');
        $limit = $this->getParam('iDisplayLength');

        $this->outputErrorIfExist();

        $cards = CardModule::getCards($cardType, $type, $status, $offset, $limit);
        $cards = CardModule::decodeCards($cards);
        $total = CardModule::countCards($cardType, $type, $status);
        $result = array('cards' => $cards, 'iTotalDisplayRecords' => $total, '_iRecordsTotal' => $total, 'iDisplayStart' => $offset, 'iDisplayLength' => $limit);

        return json_encode($result);
    }

    /**
     * 显示更新卡页面
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getUpdate($id) {
        if(! $this->isLogin()) {
            return \Redirect::to("/login");
        }
        if(! $id) {
            return \Redirect::to("card/index");
        }
        $card = CardModule::getCardById($id);
        if(empty($card)) {
            return \Redirect::to("card/index");
        }
        $cardType = CardTypeModule::getCardType(0, -1);
        $status = CardModule::$status;
        $type = CardModule::$type;
        $this->data = compact('card', 'cardType', 'status', 'type');

        return $this->showView('card/card-update');
    }

    /**
     * 更新卡请求
     *
     * @return string
     */
    public function postUpdate() {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required|numeric');
        $cardType = $this->getParam('cardType', 'required');
        $cardNo = $this->getParam('cardNo', 'required');
        $checkCode = $this->getParam('checkCode', 'required');
        $type = $this->getParam('type', 'required');
        $status = $this->getParam('status', 'required');

        $this->outputErrorIfExist();

        $result = CardModule::updateCardById($id, $cardNo, $checkCode, $cardType, $type, $status);
        $this->outputErrorIfFail($result);

        LogModule::log("更新卡：$cardNo", LogModule::TYPE_UPDATE);
        return $this->outputContent($result);
    }

    /**
     * 删除一张卡请求
     *
     * @return string
     */
    public function postDelete() {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required');
        $card = CardModule::getCardById($id);
        $name = $card->cardno;

        $this->outputErrorIfExist();

        $result = CardModule::deleteCard($id);
        $this->outputErrorIfFail($result);
        LogModule::log("删除卡：$name", LogModule::TYPE_DEL);

        return $this->outputContent($result);
    }

    /**
     * 显示卡类别页面
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getType() {
        if(! $this->isLogin()) {
            return \Redirect::to("/login");
        }
        return $this->showView('card.cardtype');
    }

    /**
     * 获取类型记录请求
     */
    public function getCardType() {
        $this->outputUserNotLogin();

        $offset = $this->getParam('iDisplayStart');
        $limit = $this->getParam('iDisplayLength');
        $limit = $limit ? $limit : RoleModule::NUM_PER_PAGE;

        $this->outputErrorIfExist();

        $types = CardTypeModule::getCardType($offset, $limit);
        $total = CardTypeModule::countCardType();
        $result = array('types' => $types, 'iTotalDisplayRecords' => $total, '_iRecordsTotal' => $total, 'iDisplayStart' => $offset, 'iDisplayLength' => $limit);
        echo json_encode($result);
    }

    /**
     * 显示增加类型页面
     *
     * @return \Illuminate\View\View
     */
    public function getTypeAdd() {
        if(! $this->isLogin()) {
            return \Redirect::to("/login");
        }
        $this->data['types'] = CardTypeModule::$type;
        return $this->showView('card.cardtype-add');
    }

    /**
     * 新增类型请求
     *
     * @return string
     */
    public function postTypeAdd() {
        $this->outputUserNotLogin();

        $name = $this->getParam('name', 'required');
        $type = $this->getParam('type', 'required');
        $sort = $this->getParam('sort', 'required');

        $this->outputErrorIfExist();
        $typeArr = "";
        foreach($type as $k => $v) {
            if($k != 0) {
                $typeArr .=",";
            }
            $typeArr .="[$v]";
        }
        $result = CardTypeModule::addCardType($name, $typeArr, $sort);
        $this->outputErrorIfFail($result);
        LogModule::log("新增卡类型：$name", LogModule::TYPE_ADD);
        return $this->outputContent($result);
    }

    /**
     * 获取类型更新页面
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getTypeUpdate($id) {
        if(! $this->isLogin()) {
            return \Redirect::to("/login");
        }

        if(! $id) {
            return Redirect::to("card/type");
        }
        $cardtype = CardTypeModule::getCardTypeById($id);
        if(empty($cardtype)) {
            return Redirect::to("card/type");
        }

        if($cardtype->type) {
            $times = preg_match_all('/\d+/', $cardtype->type, $matches);
            if($times) {
                $cardtype->type = $matches[0];
            } else {
                $cardtype->type = array();
            }
        } else {
            $cardtype->type = array();
        }
        $types = CardTypeModule::$type;
        $this->data = compact('cardtype', 'types');
        return $this->showView('card.cardtype-update');
    }

    /**
     * 更新卡类型请求
     *
     * @return string
     */
    public function postTypeUpdate() {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required');
        $name = $this->getParam('name', 'required');
        $type = $this->getParam('type', 'required');
        $sort = $this->getParam('sort', 'required');

        $this->outputErrorIfExist();
        $typeArr = "";
        foreach($type as $k => $v) {
            if($k != 0) {
                $typeArr .=",";
            }
            $typeArr .="[$v]";
        }

        $result = CardTypeModule::updateCardType($id, $name, $typeArr, $sort);
        $this->outputErrorIfFail($result);
        LogModule::log("修改卡类型：$name", LogModule::TYPE_UPDATE);
        return $this->outputContent($result);
    }

    /**
     * 删除卡类型请求
     *
     * @return string
     */
    public function postTypeDelete() {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required');
        $type = CardTypeModule::getCardTypeById($id);
        $name = $type->name;

        $this->outputErrorIfExist();

        $result = CardTypeModule::deleteCardTypeById($id);
        $this->outputErrorIfFail($result);
        LogModule::log("删除卡类型：$name", LogModule::TYPE_DEL);

        return $this->outputContent($result);
    }

    /**
     * 查看卡操作记录
     *
     * @return string
     */
    public function getLog() {
        $this->outputUserNotLogin();

        $cardId = $this->getParam('id', 'required');
        $this->outputErrorIfExist();

        $logs = CardLogModule::getCardLog($cardId, 0 , 500);
        $type = CardLogModule::$type;
        $result = array("logs" => $logs, 'type' => $type);
        return $this->outputContent($result);
    }
}