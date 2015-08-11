<?php namespace App\Controllers;
use App\Module\BaseModule;
use App\Module\CarouselModule;
use App\Module\LogModule;
use Illuminate\Support\Facades\Redirect;

/**
 * 轮播图控制器
 *
 * @package App\Controllers
 */
class CarouselController extends  BaseController {
    public $langFile = 'content';
    /**
     * 显示首页轮播图或者其他轮播图页面
     *
     * @param int $type
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getIndex($type = CarouselModule::TYPE_INDEX) {
        if(! $this->isLogin()) {
            return \Redirect::to('/login');
        }
        if($type == CarouselModule::TYPE_INDEX) {
            return $this->showView('content.carousel-index');
        }else{
            return $this->showView('content.carousel');
        }
    }

    /**
     * 获取轮播图请求
     *
     * @return string
     */
    public function getCarousel() {
        $this->outputUserNotLogin();

        $type = $this->getParam('type');
        if(! isset($type)) {
            $type = CarouselModule::TYPE_INDEX;
        }
        $offset = $this->getParam('iDisplayStart');
        $limit = $this->getParam('iDisplayLength');

        $this->outputErrorIfExist();

        $carousel = CarouselModule::getCarousels($type, $offset, $limit);
        $total = CarouselModule::countCarousel($type);
        $result = array('carousel' => $carousel, 'iTotalDisplayRecords' => $total, '_iRecordsTotal' => $total, 'iDisplayStart' => $offset, 'iDisplayLength' => $limit);
        return json_encode($result);
    }

    /**
     * 显示新增页面
     *
     * @param int $type
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getAdd($type = CarouselModule::TYPE_INDEX) {
        if(! $this->isLogin()) {
            return \Redirect::to('/login');
        }
        if($type == CarouselModule::TYPE_INDEX) {
            return $this->showView('content.carousel-index-add');
        }
        return $this->showView('content.carousel-add');
    }

    /**
     * 新增轮播图请求
     *
     * @return string
     */
    public function postAdd() {
        $this->outputUserNotLogin();

        $url = $this->getParam('url', 'required|max:100');
        $picture = $this->getParam('picture', 'required|max:100');
        $sort = $this->getParam('sort', 'required|numeric|between:1,99');
        $type = $this->getParam('type', 'required|numeric');
        $display = $this->getParam('display', 'numeric');
        $remark = $this->getParam('remark');

        $this->outputErrorIfExist();
        $result = CarouselModule::addCarousel($url, $picture, $sort, $type, $display, $remark);
        $this->outputErrorIfFail($result);
        if($type == CarouselModule::TYPE_INDEX) {
            $content = "新增首页轮播图:".$result['id'];
        }elseif($type == CarouselModule::TYPE_ETC) {
            $content = "新增ETC轮播图:".$result['id'];
        }else{
            $content = "新增旅游轮播图:".$result['id'];
        }
        LogModule::log($content, LogModule::TYPE_ADD);
        return $this->outputContent($result);
    }

    /**
     * 显示更新页面
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function getUpdate($id = 0) {
        $this->outputUserNotLogin();
        if(! $id) {
            return Redirect::to('/carousel/index');
        }
        $carousel = CarouselModule::getCarouselById($id);
        if(empty($carousel)) {
            return Redirect::to('/carousel/index');
        }
        $this->data = compact('carousel');
        if($carousel->type == CarouselModule::TYPE_INDEX) {
            return $this->showView('content.carousel-index-update');
        }
        return $this->showView('content.carousel-update');
    }

    /**
     * 修改轮播图请求
     *
     * @return string
     */
    public function postUpdate() {
        $this->outputUserNotLogin();

        $url = $this->getParam('url', 'required|max:100');
        $picture = $this->getParam('picture', 'required|max:100');
        $sort = $this->getParam('sort', 'required|numeric');
        $type = $this->getParam('type', 'required|numeric');
        $display = $this->getParam('display', 'numeric');
        $remark = $this->getParam('remark');
        $id = $this->getParam('id', 'required|numeric');

        $this->outputErrorIfExist();

        $result = CarouselModule::updateCarousel($id, $url, $picture, $sort, $type, $display, $remark);
        $this->outputErrorIfFail($result);

        if($type == CarouselModule::TYPE_INDEX) {
            $content = "修改首页轮播图:".$id;
        }elseif($type == CarouselModule::TYPE_ETC) {
            $content = "修改ETC轮播图:".$id;
        }else{
            $content = "修改旅游轮播图:".$result['id'];
        }
        LogModule::log($content, LogModule::TYPE_UPDATE);
        return $this->outputContent($result);
    }

    /**
     * 删除一个轮播图请求
     *
     * @return string
     */
    public function postDelete() {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required|numeric');
        $this->outputErrorIfExist();

        $carousel = CarouselModule::getCarouselById($id);
        $result = CarouselModule::deleteCarousel($id);
        $this->outputErrorIfFail($result);

        $content = "删除轮播图：" . $carousel->picture;
        LogModule::log($content, LogModule::TYPE_UPDATE);

        return $this->outputContent($result);
    }
}