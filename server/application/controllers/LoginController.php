<?php 

namespace application\controllers;

use \application\models\Login;

class LoginController extends AppController {

	public function __construct($route) {
	    	parent::__construct($route);
	    }

    public function signInAJAXAction() {
    	$model = new Login();
    	$model->signInVerifyAJAX($_POST['signInEmail'], $_POST['signInPassword']);
    }
}