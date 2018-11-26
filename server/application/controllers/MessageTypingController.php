<?php 

namespace application\controllers;

use \application\models\IsTyping;

class MessageTypingController extends AppController {

	public function __construct($route) {
		parent::__construct($route);
	}

	public function isTypingAction() {
		 $model = new IsTyping();
		 $model->returnIsTyping($_POST['login']);
	}
}