<?php namespace App\Module;
use App\Model\WeixinSource;

/**
 * 微信素材module层
 *
 * @package App\Module
 */
class WeixinSourceModule extends BaseModule {
    const SINGLE_MEDIA = 1;
    const MULTI_MEDIA = 2;
    const CUSTOM_MEDIA = 3;

    public static function addSource() {

    }

    public static function updateSource() {

    }

    public static function deleteSource() {

    }

    public static function getSource($keyword = '', $offset = 0, $limit = 0) {
        $source = new WeixinSource();
        $source = $source->where('is_del', 0);
        if($keyword) {
            $source = $source->where('title', 'like', "%$keyword%");
        }
        if($limit > 0) {
            $source = $source->offset($offset)->limit($limit);
        }
        return $source->get();
    }

    /**
     * 按类别格式化资源列表
     *
     * @param $sources
     * @return array
     */
    public static function formatSourceByCategory($sources) {
        $single = array();
        $multi = array();
        $custom  = array();
        foreach($sources as $source) {
            switch($source->category) {
                case self::SINGLE_MEDIA :
                    $single[] = $source;
                    break;
                case self::MULTI_MEDIA :
                    $multi[] = $source;
                    break;
                case self::CUSTOM_MEDIA :
                    $custom[] = $source;
                    break;
            }
        }
        $result = array('single' => $single, 'multi' => $multi, 'custom' => $custom);
        return $result;
    }
}