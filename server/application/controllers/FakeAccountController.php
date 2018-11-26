<?php 

namespace application\controllers;

use \application\models\Fake;

class FakeAccountController extends AppController {

	public function __construct($route) {
		parent::__construct($route);
	}

	public function sendFakeNotificationAction() {
		 $model = new Fake();
		 $model->sendFake($_POST['login']);
	}
}