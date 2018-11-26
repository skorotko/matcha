<?php 

namespace application\controllers;

use \application\models\CheckOnlineStatus;

class CheckOnlineStatusController extends AppController {

	public function __construct($route) {
		parent::__construct($route);
	}

	public function checkOnlineStatusAction() {
		$model = new CheckOnlineStatus();
		$model->CheckStatusOnOff($_POST['token']);
	}
}