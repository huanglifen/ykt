<?php namespace App\Controllers;

/**
 * 产品控制器
 *
 * @package App\Controllers
 */
class ProductController extends  BaseController {

    public function getIndex() {
        return $this->showView('content.product');
    }
}