<?php

namespace application\models;

use \application\core\base\Model;

class ResetNotifications extends Model {

	public function resetNotifications($login) {
		if(empty($login)) {
			exit;
		}
		$userName = json_decode(JWT::decode($login, "MOXghJK2dJ"), true);
		$this->resetNotificationsInDb($userName['name']);
		exit;
	}

	public function resetMessagesNotifications($login) {
		if(empty($login)) {
			exit;
		}
		$userName = json_decode(JWT::decode($login, "MOXghJK2dJ"), true);
		$this->resetMessagesInDb($userName['name']);
		exit;
	}
}