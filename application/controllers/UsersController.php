<?php

namespace application\controllers;
use application\core\Controller;

class UsersController extends Controller {

    public static function pageAction() {
        self::$view::show('PAGE.');
    }

    public static function getApi() {
        header('Content-Type: application/json');
        echo self::$model::getText();
        // It is necessary to generate JSON and return it, having make a lot of checks.
    }
}