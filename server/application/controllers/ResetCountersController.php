<?php

namespace application\controllers;

use application\models\ResetNotifications;


class ResetCountersController extends AppController {

	public function __construct($route) {
		parent::__construct($route);
	}

	public function notificationsAction() {
		$model = new ResetNotifications();
		$model->resetNotifications($_POST['login']);
	}

	public function messagesAction() {
		$model = new ResetNotifications();
		$model->resetMessagesNotifications($_POST['login']);
	}
}