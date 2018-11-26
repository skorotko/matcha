<?php

namespace application\controllers;

use \application\models\Activation;


class ActivationController extends AppController {
	
	function __construct($route) {
		parent::__construct($route);
	}

	public function activationAction() {
		$model = new Activation();
		$model->checkConfirmUrl($_POST['hash']);
        
    }
}
