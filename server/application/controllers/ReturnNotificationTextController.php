<?php 

namespace application\controllers;

use application\models\ReturnNotificationText;

/**
* Controller for reading notifications
*
* When user want to see his notifications vuejs send him to this controller in
* returnNotificationTextAction. We need some headers because this class
* is called by ajax.
*
* @author   Vitalii Sarapin <vsarapin@student.unit.ua>
* @access   public
*/
class ReturnNotificationTextController extends AppController {

	public function __construct($route) {
		parent::__construct($route);
	}

	public function returnNotificationTextAction() {
		$model = new ReturnNotificationText();
		$model->readNotificationFile($_POST['login']);
	}
}