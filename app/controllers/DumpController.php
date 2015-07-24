<?php namespace App\Controllers;

use App\Module\DumpModule;

class DumpController extends BaseController {

    public function getIndex() {

    }

    public function postDump() {
        $this->outputUserNotLogin();

        $result = DumpModule::dumpDataBase();
    }

}