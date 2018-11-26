<?php

namespace application\controllers;

use \application\models\JWT;
use \application\models\SaveUserLikes;
use \application\models\SaveMessagesCounter;

class TokenController extends AppController {
	
	public function __construct($route) {
		parent::__construct($route);
	}

	public function getTokenAction() {
		$object = json_encode(["name" => $_POST['userLogin']]);
		$mess   = JWT::encode($object, "MOXghJK2dJ");

		echo $mess;
		exit;
	}

	public function decodeTokenAction() {
		$model = new SaveUserLikes($_POST['login']);
		$model->saveUsersLikes();
	}

	public function addMessagesCounterAction() {
		$model = new SaveMessagesCounter();
		$model->saveUsersMessages($_POST['login'], $_POST['hisLogin']);
	}

	public function addMessagesPersonalCounterAction() {
		$model = new SaveMessagesCounter();
		$model->saveUsersPersonalMessages($_POST['login'], $_POST['hisLogin']);
	}
}