<?php

namespace application\core;

class Router {

    protected $routes = [];
    protected $routesArray = [];
    protected $params = [];

    public function addRoutes() {

        $allowedRoutes = require 'application/config/routes.php';
        foreach($allowedRoutes as $route => $routeArray) {
            $this->add($route, $routeArray);
        }

    }

    public function addApi() {

        $allowedRoutes = require 'application/config/api.php';
        foreach($allowedRoutes as $route => $routeArray) {
            $this->add($route, $routeArray);
        }

    }

    public function isApi($route) {

        return preg_match('/api\/(.*)\.(.*)/', $route); // Incomplete regex
    }

    public function add($route, $routeArray) {
        $route = '#^'.$route.'$#';
        $this->$routes[$route] = $routeArray;
    }

    public function matchRoute() {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        
        foreach($this->$routes as $route => $routeArray) {

            if(preg_match($route, parse_url($url, PHP_URL_PATH))) {

                $this->routesArray = $routeArray;
                $this->params = parse_url($url, PHP_URL_QUERY) != NULL ? parse_url($url, PHP_URL_QUERY) : '';
                return true;

            }

        }

        return false;

    }

    public function matchApi() {

        $url = trim($_SERVER['REQUEST_URI'], '/api');
        list($controller, $method) = explode(".", $url);

        foreach($this->$routes as $route => $routeArray) {

            if(preg_match($route, parse_url($url, PHP_URL_PATH))) {

                $this->routesArray = $routeArray;
                $this->params = parse_url($url, PHP_URL_QUERY) != NULL ? $_GET : '';
                return true;

            }

        }

        return false;

    }

    public function run() {

        if($this->isApi(trim($_SERVER['REQUEST_URI'], '/'))) {
            $this->addApi();
            if($this->matchApi()) {
                
                $path = 'application\controllers\\'.ucfirst($this->routesArray['controller']).'Controller';

                if(class_exists($path)) {

                    $method = $this->routesArray['method'].'Api';

                    if(method_exists($path, $method)) {

                        $controller = new $path($this->routesArray);
                        $controller->$method($this->params);

                    } else {

                        View::errorCode(404);

                    }
                }
                else {

                    View::errorCode(404);

                }
            } else {

                View::errorCode(404);

            }
        } else {

            $this->addRoutes();
            if($this->matchRoute()) {

                $path = 'application\controllers\\'.ucfirst($this->routesArray['controller']).'Controller';

                if(class_exists($path)) {
                    
                    $action = $this->routesArray['action'].'Action';

                    if(method_exists($path, $action)) {

                        $controller = new $path($this->routesArray);
                        $controller->$action();

                    } else {

                        View::errorCode(404);
                        
                    }
                } else {

                    View::errorCode(404);
                    
                }
            } else {

                View::errorCode(404);

            }

        }
    }
}