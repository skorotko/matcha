<?php

namespace application\controllers;

use application\models\CountMessagesNotifications;


class CountMessagesNotificationsController extends AppController {
	
	public function __construct($route) {
		parent::__construct($route);
	}

	public function countMessagesNotificationsAction() {
		$model = new CountMessagesNotifications();
		$model->returnCountMessagesNotifications($_POST['login']);
	}
}