<?php

namespace application\controllers;

use application\models\Messages;


class GetMessagesController extends AppController {

	public function __construct($route) {
		parent::__construct($route);
	}

	public function returnMessagesAction() {
		$model = new Messages();
		$model->returnMessages($_POST['login']);
	}

	public function getChatWithUserAction() {
		$model = new Messages();
		$model->returnMessagesWithUser($_POST['login']);
	}
}