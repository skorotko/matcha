<?php

namespace application\models;

use \application\core\base\Model;

class IsTyping extends Model {

	public function returnIsTyping($fromSocket) {
		$whoTyping  = json_decode(JWT::decode($fromSocket[0], "MOXghJK2dJ"), true);
		$whomTyping = trim($fromSocket[1]);
		$me         = $whoTyping['name'];
		$you        = $whomTyping;
		$isTyping   = $fromSocket[2];

		$returnObject = json_encode([
			"name" 		  => $you,
			"whoIsTyping" => $me,
			"message"	  => $me . " " . $isTyping
		]);
		echo $returnObject;
		exit;
	}
}