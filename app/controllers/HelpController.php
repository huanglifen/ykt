<?php namespace App\Controllers;

/**
 * 帮助控制器
 *
 * @package App\Controllers
 */
class HelpController extends  BaseController {

    /**
     * 帮助页面
     *
     * @return \Illuminate\View\View
     */
    public function getIndex() {
        return $this->showView('content.help');
    }
}