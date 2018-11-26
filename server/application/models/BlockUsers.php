<?php

namespace application\models;

use \application\core\base\Model;

class BlockUsers extends Model {

	public function blockUser($login, $blockThis) {
		$userName = json_decode(JWT::decode($login, "MOXghJK2dJ"), true);
		$me  = $userName['name'];
		$you = $blockThis;
		$this->table = "users_profile";
		$concatenation = $this->findOne($userName['name'], "login");
		$blockThis = $concatenation[0]['blockedUsers'] . "." . $blockThis . ".";
		$this->addBlockedUser($userName['name'], $blockThis);
		if (file_exists(WWW . "/history/messages/$you/$me.txt")) {
			unlink(WWW . "/history/messages/$you/$me.txt");
		}
		if (file_exists(WWW . "/history/messages/$me/$you.txt")) {
			unlink(WWW . "/history/messages/$me/$you.txt");
		}
	}
}