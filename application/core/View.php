<?php

namespace application\core;

class View {

    public $route; // controller/action
    public $routeArray; // array: controller and action
    public $layout = 'default';

    public function __construct($route) {

        $this->routeArray = $route;
        $this->route = $route['controller'].'/'.$route['action'];
        
    }

    public function show($title) {

        $path = 'application/views/'.$this->route.'.php';

        if(file_exists($path)) {

            ob_start();
            require $path;
            $content = ob_get_clean();
            require 'application/views/layouts/'.$this->layout.'.php';

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