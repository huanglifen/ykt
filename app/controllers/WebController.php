<?php namespace App\Controllers;

use App\Module\LogModule;
use App\Module\WebModule;

/**
 * 站点控制器
 *
 * @package App\Controllers
 */
class WebController extends BaseController {
    /**
     * 显示网站页面
     *
     * @return \Illuminate\View\View
     */
    public function getIndex() {
        if(! $this->isLogin()) {
            return \Redirect::to('/login');
        }
        $info = WebModule::getWebInfo();
        $this->data = compact('info');
        return $this->showView('setting.web');
    }

    /**
     * 更新网站信息
     *
     * @return string
     */
    public function postWeb() {
        $this->outputUserNotLogin();

        $name = $this->getParam('name');
        $site = $this->getParam('site');
        $abbr = $this->getParam('abbr');
        $fillNumber = $this->getParam('fillNumber');
        $title = $this->getParam('title');
        $keyword = $this->getParam('keyword');
        $describe = $this->getParam('describe');
        $headLog = $this->getParam('headLogo');
        $bottomLog = $this->getParam('bottomLogo');
        $code = $this->getParam('code');
        $weibo = $this->getParam('weibo');
        $qq = $this->getParam('qq');

        $this->outputErrorIfExist();

        $result = WebModule::updateWebInfo($name, $site, $abbr, $fillNumber, $title, $keyword, $describe, $headLog, $bottomLog, $code, $weibo, $qq);
        $this->outputErrorIfFail($result);

        LogModule::log("更新网站站点信息", LogModule::TYPE_UPDATE);
        return $this->outputContent($result);
    }
}