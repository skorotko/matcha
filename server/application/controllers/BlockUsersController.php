<?php 

namespace application\controllers;

use \application\models\BlockUsers;

class BlockUsersController extends AppController {

	public function __construct($route) {
		parent::__construct($route);
	}

	public function BlockUserAction() {
		 $model = new BlockUsers();
		 $model->blockUser($_POST['login'], $_POST['blockUser']);
	}
}