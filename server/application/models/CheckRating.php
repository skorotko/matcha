<?php

namespace application\models;

use \application\core\base\Model;
use application\models\JWT;

class CheckRating extends Model {

	public function checkRating($login) {
		$this->table = "base_registration_data";
		$userName = json_decode(JWT::decode($login, "MOXghJK2dJ"), true);
		if (!count($userName) || empty($userName['name'])) {
			echo "empty";
			exit;
		}
		$checkRating = $this->findOne($userName['name'], "login");
		if ($checkRating[0]['rating'] >= 60) {
			echo "false";
			exit;
		}
	}

	public function returnRating($login) {
		$this->table = "base_registration_data";
		$checkRating = $this->findOne($login, "login");
		if ($checkRating && $checkRating[0]['rating'] >= 60) {
			echo $checkRating[0]['rating'];
			exit;
		} else {
			echo "0";
			exit;
		}
	}

	public function returnRatingAfterFilling($login) {
		$this->table = "base_registration_data";
		$userName = json_decode(JWT::decode($login, "MOXghJK2dJ"), true);
		$checkRating = $this->findOne($userName['name'], "login");
		if ($checkRating && $checkRating[0]['rating'] >= 60) {
			echo $checkRating[0]['rating'];
			exit;
		} else {
			echo "0";
			exit;
		}
	}
}