<?php 

namespace application\controllers;

use \application\models\ReadingChat;

class ReadingChatController extends AppController {

	public function __construct($route) {
			parent::__construct($route);
		}

		public function readingChatAction() {
			$model = new ReadingChat();
			$model->returnReadingChat($_POST['login']);
		}
}