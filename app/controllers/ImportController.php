<?php  namespace App\Controllers;

use Maatwebsite\Excel\Facades\Excel;

class ImportController extends BaseController{

    public function postCards() {
        Excel::load(\Input::file("file"), function($reader) {
            $reader = $reader->getSheet(0);
            $results = $reader->toArray();
        });
    }
}