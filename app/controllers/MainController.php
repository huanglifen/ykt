<?php namespace App\Controllers;

class MainController extends BaseController {

    public function getLogIn() {
       return $this->showView("main.login");
    }

    public function postLogIn() {

    }

    public function getLogOut() {

    }

    public function getIndex() {
        return $this->showView("main.index");
    }
}
