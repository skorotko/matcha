<?php 

namespace application\controllers;

use \application\models\ReturnViewProfileNotification;

class ViewProfileNotificationController extends AppController {

		public function __construct($route) {
			parent::__construct($route);
		}

		public function viewProfileNotificationAction() {
			$model = new ReturnViewProfileNotification($_POST['login']);
			$model->returnProfileNotification();
		}
}