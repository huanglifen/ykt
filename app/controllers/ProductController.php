<?php namespace App\Controllers;
use App\Module\CardTypeModule;
use App\Module\ProductModule;

/**
 * 产品介绍控制器
 *
 * @package App\Controllers
 */
class ProductController extends  BaseController {

    /**
     * 卡产品介绍页面
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getIndex() {
        if(! $this->isLogin()) {
            return \Redirect::to('/login');
        }
        return $this->showView('content.product');
    }

    /**
     * 获取卡产品介绍记录请求
     *
     * @return string
     */
    public function getProduct() {
        $this->outputUserNotLogin();

        $keyword = $this->getParam('keyword');
        $offset = $this->getParam('iDisplayStart');
        $limit = $this->getParam('iDisplayLength');

        $this->outputErrorIfExist();

        $products = ProductModule::getProducts($keyword, $offset, $limit);
        $total = ProductModule::countProducts($keyword);
        $result = array('products' => $products, 'iTotalDisplayRecords' => $total, '_iRecordsTotal' => $total, 'iDisplayStart' => $offset, 'iDisplayLength' => $limit);
        return json_encode($result);
    }

    /**
     * 显示新增页面
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getAdd() {
        if(! $this->isLogin()) {
            return \Redirect::to('/login');
        }
        $cardType = CardTypeModule::getCardType(0, 0);
        $this->data = compact('cardType');
        return $this->showView('content.product-add');
    }

    /**
     * 新增一个产品介绍请求
     *
     * @return string
     */
    public function postAdd() {
        $this->outputUserNotLogin();
        $name = $this->getParam('name', 'required|max:100');
        $picture = $this->getParam('picture', 'required|max:100');
        $describe = $this->getParam('describe', 'required|max:1000');
        $type = $this->getParam('type', 'required|numeric');

        $this->outputErrorIfExist();

        $result = ProductModule::addProduct($name, $picture, $type, $describe);
        $this->outputErrorIfFail($result);
        return $this->outputContent($result);
    }

    /**
     * 显示产品介绍更新页面
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getUpdate($id) {
        if(! $this->isLogin()) {
            return \Redirect::to('/login');
        }
        if(! $id) {
            return \Redirect::to('/product/index');
        }
        $product = ProductModule::getProductById($id);
        if(empty($product)) {
            return \Redirect::to('/product/index');
        }
        $cardType = CardTypeModule::getCardType(0, 0);
        $this->data = compact('cardType', 'product');
        return $this->showView('content.product-add');
    }

    /**
     * 更新一个产品介绍请求
     *
     * @return string
     */
    public function postUpdate() {
        $this->outputUserNotLogin();
        $name = $this->getParam('name', 'required|max:100');
        $picture = $this->getParam('picture', 'required|max:100');
        $describe = $this->getParam('describe', 'required|max:1000');
        $type = $this->getParam('type', 'required|numeric');
        $id = $this->getParam('id', 'required|numeric');

        $this->outputErrorIfExist();

        $result = ProductModule::updateProduct($id, $name, $picture, $type, $describe);
        $this->outputErrorIfFail($result);
        return $this->outputContent($result);
    }

    /**
     * 删除一个产品介绍请求
     *
     * @return string
     */
    public function postDelete() {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required|numeric');
        $this->outputErrorIfExist();

        $result = ProductModule::deleteProduct($id);
        $this->outputErrorIfFail($result);
        return $this->outputContent($result);
    }
}