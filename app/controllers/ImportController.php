<?php  namespace App\Controllers;

use App\Module\CardModule;
use App\Module\LogModule;
use App\Utils\Utils;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends BaseController{
    public $langFile = 'import';
    public $destination = 'data/';

    /**
     * 上传卡片
     */
    public function postCards() {
        if (! \Input::hasFile ( 'file' )) {
            $result = array('status' => false, 'msg' => 'error_file_not_exist');
            return $this->outputErrorIfFail($result);
        }
        $file = \Input::file ( 'file' );

        $size = $file->getSize ();

        if ($size > 1024 * 1024 * 2) {
            $result = array('status' => false, 'msg' => 'error_file_too_large');
            return $this->outputErrorIfFail($result);
        }

        $extension = $file->getClientOriginalExtension ();

        if (! in_array ( $extension, array (
            'xls',
            'xlsx'
        ) )) {
            $result = array('status' => false, 'msg' => 'error_file_type');
            return $this->outputErrorIfFail($result);
        }

        Excel::load(\Input::file("file"), function($reader) {
            $reader = $reader->getSheet(0);
            $results = $reader->toArray();
            array_shift($results);

            $result = CardModule::importCards($results);
            if($result['success'] > 0) {
                LogModule::log("成功导入卡记录" . $result['success'] . "条", LogModule::TYPE_ADD);
            }
            echo $this->outputContent($result);
        });
    }

    /**
     * 上传图片
     */
    public function postPicture() {
        if (! \Input::hasFile ( 'file' )) {
            $result = array('status' => false, 'msg' => 'error_file_not_exist');
            return $this->outputErrorIfFail($result);
        }
        $file = \Input::file ( 'file' );

        $size = $file->getSize ();

        if ($size > 1024 * 1024 * 2) {
            $result = array('status' => false, 'msg' => 'error_file_too_large');
            return $this->outputErrorIfFail($result);
        }

        $extension = $file->getClientOriginalExtension ();

        if (! in_array ( $extension, array (
            'gif',
            'png',
            'jpg',
            'jpeg'
        ) )) {
            $result = array('status' => false, 'msg' => 'error_file_type');
            return $this->outputErrorIfFail($result);
        }
        Utils::createDirectoryIfNotExist($this->destination);

        $fileName = time() . '_';
        $fileNewName = $fileName . md5_file($file->getRealPath()) . '.' . $extension;
        $file->move($this->destination, $fileNewName);
        $fileNewPath = $this->destination  . $fileNewName;
        return $this->outputContent($fileNewPath);
    }
}