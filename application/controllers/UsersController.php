<?php

namespace application\controllers;
use application\core\Controller;

class UsersController extends Controller {

    public function pageAction() {
        $this->view->show('PAGE.');
    }
    
    public function getApi($get) {
        header('Content-Type: application/json');
        var_dump($get);
        var_dump($this->model->getText());
        // It is necessary to generate JSON and return it, having make a lot of checks.
    }

}