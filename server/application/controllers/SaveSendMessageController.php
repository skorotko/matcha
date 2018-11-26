<?php

namespace application\controllers;

use application\models\SaveMessages;


class SaveSendMessageController extends AppController {

	public function __construct($route) {
		parent::__construct($route);
	}

	public function saveSendMessageAction() {
		$model = new SaveMessages();
		$model->saveMessages($_POST['login']);
	}

	public function changeSeenStatusAction() {
		$model = new SaveMessages();
		$model->changeSeenStatus($_POST['myLogin'], $_POST['hisLogin']);
	}

		public function saveMessagesPersonalCounterAction() {
		$model = new SaveMessages();
		$model->changeMessagesPersonalCounter($_POST['myLogin'], $_POST['hisLogin']);
	}
}