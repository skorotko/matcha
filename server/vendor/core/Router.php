<?php

namespace vendor\core;

class Router{
    protected static $routes = [];
    protected static $route = [];

    public static function add($regexp, $route = []){
        self::$routes[$regexp] = $route;
}

    public static function matchRoute($url){
        foreach (self::$routes as $pattern => $route){
            if(preg_match("#$pattern#i", $url, $matches)){
                foreach ($matches as $k =>$v){
                    if(is_string($k))
                        $route[$k] = $v;
                }
                if(!isset($route['action'])){
                    $route['action'] = 'index';
                }
                $route['controller'] = self::upperCamelCase($route['controller']);
                self::$route = $route;
                return true;
            }
        }
        return false;
    }

    public static function dispatch($url){
        $url = self::removeQuerystring($url);
        if(self::matchRoute($url)){
            $controller = 'application\controllers\\' . self::upperCamelCase(self::$route['controller']) . "Controller";
            if(class_exists($controller)){
               $cObj = new $controller(self::$route);
               $action = self::lowerCamelCase(self::$route['action']) . 'Action';
               if(method_exists($cObj, $action)){
                   $cObj->$action();
                   /*$cObj->getView();*/
               }else{
                   echo "metod $controller::$action</b>not found";
               }
            }else{
                echo "controller <b>$controller</b> not found";
            }
        }else{
            http_response_code(404);
            include '404.html';
        }
    }

    protected static function upperCamelCase($name){
        $name = str_replace('-', ' ', $name);
        $name = ucwords($name);
        $name = str_replace(' ', '', $name);
        return($name);
    }

    protected static function lowerCamelCase($name){
        return lcfirst(self::upperCamelCase($name));
    }

    protected static function removeQuerystring($url){
        if($url){
            $params = explode('&', $url, 2);
            if(false === strpos($params[0], '=')){
                return rtrim($params[0], '/');
            }else{
                return '';
            }
        }
    }
}