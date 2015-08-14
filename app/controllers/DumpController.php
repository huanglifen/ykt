<?php namespace App\Controllers;

use App\Module\DumpModule;
use App\Module\LogModule;
use Illuminate\Support\Facades\App;

class DumpController extends BaseController {

    public $sqlPath = "database/seeds";
    public $langFile = "setting";

    /**
     * 备份页面
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getIndex() {
        if(! $this->isLogin()) {
            return \Redirect::to('/login');
        }
        $dump = DumpModule::getLastedDump();
        if($dump->path) {
            $last = strrpos($dump->path, "/");
            $path = "app/" . $this->sqlPath;;
            $fileName = substr($dump->path, $last + 1);
            $explode = explode('.', $fileName);
            $ext = $explode[1];
        }else{
            $path = '';
            $fileName = '';
            $ext = '';
        }
        $this->data = compact('dump', 'path', 'fileName', 'ext');
        return $this->showView('setting.dump');
    }

    /**
     * 数据备份
     *
     * @return string
     */
    public function postDump() {
        $this->outputUserNotLogin();

        $appPath = app_path();
        $dumpPath = $appPath . "/" . $this->sqlPath;

        $result = DumpModule::dumpDataBase($dumpPath);
        $this->outputErrorIfFail($result);

        $fileSize = abs(filesize($result['target']));
        $return = DumpModule::addDump($result['target'], $fileSize);
        $this->outputErrorIfFail($return);

        LogModule::log("数据备份", LogModule::TYPE_UPDATE);
        return $this->outputContent($result);
    }

    /**
     * 数据备份请求
     *
     * @return string
     */
    public function postRecovery() {
        $this->outputUserNotLogin();

        $appPath = app_path();
        $dumpPath = $appPath . "/" . $this->sqlPath . "/bak";
        DumpModule::dumpDataBase($dumpPath);

        $lastDump = DumpModule::getLastedDump();
        if(! $lastDump->path) {
            $result = array('status' => false, 'msg' => 'error_cannot_find_dump');
        }else{
            $result = DumpModule::recovery($lastDump->path);
        }
        $this->outputErrorIfFail($result);

        LogModule::log("数据恢复", LogModule::TYPE_UPDATE);
        return $this->outputContent($result);
    }

}