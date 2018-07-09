<?php
/**
 * Created by PhpStorm.
 * User: skorotko
 * Date: 5/17/18
 * Time: 12:25 PM
 */

namespace vendor\core\base;


abstract class Controller{

    public $route = [];
    public $view;
    public $layout;
    public $vars = [];

    public function __construct($route){
        $this->route = $route;
        $this->view = $route['action'];
    }

    public function getView(){
        echo $this->layout;
        $vObj = new View($this->route, $this->layout, $this->view);
        $vObj->render($this->vars);
    }

    public function set($vars){
        $this->vars = $vars;
    }
}