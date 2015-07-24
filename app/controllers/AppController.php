<?php namespace App\Controllers;

use App\Module\WebModule;
use App\Utils\Utils;

class AppController extends BaseController {
    public $app = 'app/';

    /**
     * 显示app页面
     *
     * @return \Illuminate\View\View
     */
    public function getIndex() {
        if(! $this->isLogin()) {
            return $this->showView('/login');
        }

        $this->data['appPath'] = WebModule::getAppPath();
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

        WebModule::updateAppPath($fileNewPath);
        return $this->outputContent($fileNewPath);
    }
}