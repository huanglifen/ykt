<?php namespace App\Module;

use App\Model\Carousel;

/**
 * 轮播图module
 *
 * @package App\Module
 */
class CarouselModule extends BaseModule {
    const TYPE_INDEX = 1; //首页轮播
    const TYPE_ETC = 2; //ETC
    const TYPE_TRAVEL = 3; //旅游

    public static function addCarousel($url, $picture, $sort, $type, $display, $remark = '') {
        $carousel = new Carousel();
        $carousel->url = $url;
        $carousel->picture = $picture;
        $carousel->sort = $sort;
        $carousel->type = $type;
        $carousel->display = $display;
        $carousel->remark = $remark ? $remark : '';

        $carousel->save();
        return array('status' => true, 'id' => $carousel->id);
    }

    /**
     * 删除轮播图
     *
     * @param $id
     * @return array
     */
    public static function deleteCarousel($id) {
        $carousel = Carousel::find($id);
        if(empty($carousel)) {
            return array('status' => false, 'name' => '');
        }
        Carousel::destroy($id);
        return array('status' => true, 'name' => $carousel->name);
    }

    /**
     * 更新一个轮播图
     *
     * @param $id
     * @param $picture
     * @param $sort
     * @param $type
     * @param $display
     * @param $remark
     * @return array
     */
    public static function updateCarousel($id, $url, $picture, $sort, $type, $display, $remark) {
        $carousel = Carousel::find($id);
        if(empty($carousel)) {
            return array('status' => false, 'msg' => 'error_id_not_exist');
        }
        $carousel->picture = $picture;
        $carousel->sort = $sort;
        $carousel->url = $url;
        $carousel->type = $type;
        $carousel->display = $display;
        $carousel->remark = $remark ? $remark : '';
        $carousel->update();
        return array('status' => true);
    }

    /**
     * 按条件获取轮播图
     *
     * @param int $type
     * @param int $limit
     * @param int $offset
     * @param bool $asc
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getCarousels($type = self::TYPE_INDEX, $limit = 0, $offset = 0, $asc = true) {
        $carousel = new Carousel();
        if($type != 0) {
            $carousel = $carousel->where('type', $type);
        }else{
            $carousel = $carousel->whereIn('type', array(self::TYPE_TRAVEL, self::TYPE_ETC));
        }
        if($limit > 0) {
            $carousel = $carousel->offset($offset)->limit($limit);
        }
        if($asc) {
            $carousel = $carousel->orderBy('sort');
        }
        return $carousel->get();
    }

    /**
     * 按条件统计轮播图
     *
     * @param $type
     * @return int
     */
    public static function countCarousel($type) {
        $carousel = new Carousel();
        if($type != 0) {
            $carousel = $carousel->where('type', $type);
        }else{
            $carousel = $carousel->whereIn('type', array(self::TYPE_TRAVEL, self::TYPE_ETC));
        }
        return $carousel->count();
    }

    /**
     * 按主键获取轮播图
     *
     * @param $id
     * @return \Illuminate\Support\Collection|null|static
     */
    public static function getCarouselById($id) {
        return Carousel::find($id);
    }
}