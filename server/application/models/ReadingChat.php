<?php

namespace application\models;

use \application\core\base\Model;

class ReadingChat extends Model {

	public function returnReadingChat($login) {
		$userName = json_decode(JWT::decode($login[0], "MOXghJK2dJ"), true);
		$me  = $userName['name'];
		$you = $login[1];
		
	}
}