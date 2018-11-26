<?php

namespace application\core\base;

abstract class  Controller {

    public $route = [];
    public $view;
    public $layout;

    public function __construct($route) {
        $this->route = $route;
        $this->view = $route['action'];
        header('Cache-Control: no-cache, must-revalidate');
        header('Content-type: application/json');
        header('Access-Control-Allow-Headers: Content-Type');
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: POST,GET,OPTIONS');
        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
        $_POST = json_decode(file_get_contents('php://input'), true);
    }

    public function getView() {
        $vObj = new View($this->route, $this->layout, $this->view);
        $vObj->render();
    }
}
?>