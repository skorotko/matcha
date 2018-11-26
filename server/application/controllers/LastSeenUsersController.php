<?php 

namespace application\controllers;

use \application\models\ReturnLastSeenUsers;

class LastSeenUsersController extends AppController {

	public function __construct($route) {
		parent::__construct($route);
	}

	public function lastSeenUsersAction() {
		 $model = new ReturnLastSeenUsers();
		 $model->echoLastSeenUsers($_POST['login']);
	}
}