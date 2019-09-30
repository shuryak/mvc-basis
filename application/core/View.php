<?php

namespace application\core;

class View {

    public static $route; // controller/action
    public static $routeArray; // array: controller and action
    public static $layout = 'default';

    public static function load($route) {
        self::$routeArray = $route;
        self::$route = $route['controller'].'/'.$route['action'];
    }

    public static function show($title) {
        $path = 'application/views/'.self::$route.'.php';

        if(file_exists($path)) {
            ob_start();
            require $path;
            $content = ob_get_clean();
            require 'application/views/layouts/'.self::$layout.'.php';
        } else {
            echo 'View not found.';
        }
    }

    public static function errorCode($code) {

        http_response_code($code);
        $path = 'application/views/errors/'.$code.'.php';

        if(file_exists($path)) {

            require $path;

        } else {

            echo 'Unknown error.';

        }

    }

}