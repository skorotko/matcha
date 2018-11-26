<?php

namespace application\models;

use \application\core\base\Model;

class ChangeOnlineStatus extends Model {

	public function ChangeOnlineStatus($token) {
		if (!isset($token)) {
			exit;
		}
		date_default_timezone_set('Europe/Kiev');
		$currentTime = "\"" . "Last seen " . date('d-m-Y') . " at " . date('H:i') . "\"";
		$status = 0;
		$userName = json_decode(JWT::decode($token, "MOXghJK2dJ"), true);
        $this->updateOnlineStatus($status, $userName['name']);
        $this->updateLogoutTime($currentTime, $userName['name']);
        exit;
	}
}