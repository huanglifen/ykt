<?php namespace App\Controllers;

use App\Module\AppModule;
use App\Module\LogModule;
use App\Utils\Utils;

class AppController extends BaseController {
    public $app = 'app/';
    protected $langFile = 'setting';

    /**
     * 显示app页面
     *
     * @return \Illuminate\View\View
     */
    public function getIndex() {
        if(! $this->isLogin()) {
            return $this->showView('/login');
        }

        $this->data['app'] = AppModule::getApp();
        return $this->showView('setting.app');
    }

    /**
     * 上传app
     *
     * @return string|void
     */
    public function postApp() {
        if (! \Input::hasFile ( 'file' )) {
            $result = array('status' => false, 'msg' => 'error_file_not_exist');
            return $this->outputErrorIfFail($result);
        }
        $file = \Input::file ( 'file' );

        $size = $file->getSize ();
        if ($size > 1024 * 1024 * 500) {
            $result = array('status' => false, 'msg' => 'error_file_too_large');
            return $this->outputErrorIfFail($result);
        }
        $extension = $file->getClientOriginalExtension ();

        if (! in_array ( $extension, array (
            'apk',
        ) )) {
            $result = array('status' => false, 'msg' => 'error_file_type');
            return $this->outputErrorIfFail($result);
        }
        Utils::createDirectoryIfNotExist($this->app);

        $name = $file->getClientOriginalName();
        $name = explode('.', $name);
        $originName = $name[0];
        $fileName = $originName . '_' . time() . '_';
        $fileNewName = $fileName . '.' . $extension;
        $file->move($this->app, $fileNewName);
        $fileNewPath = $this->app  . $fileNewName;

        return $this->outputContent($fileNewPath);
    }

    /**
     * 设置APP上传信息
     *
     * @return string
     */
    public function postAdd() {
        $this->outputUserNotLogin();

        $path = $this->getParam('path', 'required');
        $version = $this->getParam('version');
        $remark = $this->getParam('remark');
        $url = $this->getParam('url');
        $share = $this->getParam('share');

        $this->outputErrorIfExist();

        $result = AppModule::setAppInfo($path, $version, $remark, $url, $share);
        $this->outputErrorIfFail($result);

        LogModule::log("上传APP" . $version, LogModule::TYPE_ADD);
        return $this->outputContent($result);
    }
}