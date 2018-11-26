<?php

namespace application\models;

use \application\core\base\Model;

class ReturnLastSeenUsers extends Model {

	public function echoLastSeenUsers($login) {
		$this->table = "users_profile";
		$users = $this->findOne($login['name'], "login");
		// print_r($users);
		// exit;
		if (!empty($users[0]['SeenUsers'])) {
			$users[0]['SeenUsers'] = explode('.', $users[0]['SeenUsers']);
			$users[0]['SeenUsers'] = array_filter($users[0]['SeenUsers'], function($element) {
					return !empty($element);
				});
			echo json_encode($users[0]['SeenUsers']);
			exit;
		} else {
			echo "empty";
			exit;
		}
	}
}