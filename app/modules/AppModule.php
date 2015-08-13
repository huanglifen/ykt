<?php namespace App\Module;

use App\Model\App;

/**
 * App module层
 *
 * @package App\Module
 */
class AppModule extends BaseModule {

    /**
     * 设置app上传信息
     *
     * @param $path
     * @param $version
     * @param string $remark
     * @param string $url
     * @param string $share
     * @return array
     */
    public static function setAppInfo($path, $version, $remark = '', $url = '', $share = '') {
        $app = App::first();
        if(empty($app)) {
           $app = new App();
        }
        $app->path = $path;
        $app->version = $version;
        $app->remark = $remark;
        $app->url = $url;
        $app->share = $share;

        $app->save();
        return array('status' => true, 'id' => $app->id);
    }

    /**
     * 获取App
     *
     * @return App|\Illuminate\Database\Eloquent\Model|null|static
     */
    public static function getApp() {
        $app = App::first();
        if(empty($app)) {
            $app = new App();
            $app->path = '';
            $app->version = '';
            $app->remark = '';
            $app->url = '';
            $app->share = '';
        }
        return $app;
    }
}