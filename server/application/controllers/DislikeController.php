<?php 

namespace application\controllers;

use \application\models\Dislike;

class DislikeController extends AppController {

	public function __construct($route) {
			parent::__construct($route);
		}

		public function dislikeAction() {
			$model = new Dislike($_POST['login']);
			$model->dislike();
		}
}