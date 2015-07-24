<?php namespace App\Module;

use App\Model\Web;

/**
 * 站点module层
 *
 * @package App\Module
 */
class WebModule extends BaseModule {

    /**
     * 添加或者更新网站信息
     *
     * @param $name
     * @param $site
     * @param $abbr
     * @param $fillNumber
     * @param $title
     * @param $keyword
     * @param $describe
     * @param $headLog
     * @param $bottomLog
     * @param $code
     * @param $weibo
     * @param $qq
     * @return array
     */
    public static function updateWebInfo($name, $site, $abbr, $fillNumber, $title, $keyword, $describe, $headLog, $bottomLog, $code, $weibo, $qq) {
        $info = Web::first();
        if(empty($info)) {
            $info = new Web();
        }
        $info->name = $name;
        $info->site = $site;
        $info->abbr = $abbr;
        $info->title = $title;
        $info->filling_number = $fillNumber;
        $info->keyword = $keyword;
        $info->describe = $describe;
        $info->head_logo = $headLog;
        $info->bottom_logo = $bottomLog;
        $info->code = $code;
        $info->weibo = $weibo;
        $info->qq = $qq;

        $info->save();
        return array('status' => true);
    }

    /**
     * 获取网站信息
     *
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public static function getWebInfo() {
        $info = Web::first();
        if(empty($info)) {
            $info = new Web();
            $info->name = '';
            $info->site = '';
            $info->abbr = '';
            $info->title = '';
            $info->filling_number = '';
            $info->keyword = '';
            $info->describe = '';
            $info->head_logo = '';
            $info->bottom_logo = '';
            $info->code = '';
            $info->weibo = '';
            $info->qq = '';
        }
        return $info;
    }
}