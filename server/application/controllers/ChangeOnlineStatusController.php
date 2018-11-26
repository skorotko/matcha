<?php

namespace application\controllers;

use \application\models\ChangeOnlineStatus;

class ChangeOnlineStatusController extends AppController {
	
	function __construct($route) {
		parent::__construct($route);
	}

	public function changeOnlineStatusAction() {
		$model = new ChangeOnlineStatus();
		$model->ChangeOnlineStatus($_POST['token']);
	}
}