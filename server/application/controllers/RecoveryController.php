<?php 

namespace application\controllers;

use \application\models\Recovery;

class RecoveryController extends AppController {

	public function __construct($route) {
		parent::__construct($route);
	}

	public function recoveryAction() {
		 $model = new Recovery();
		 $model->passwordRecovery($_POST['recoveryEmail']);
	}
}