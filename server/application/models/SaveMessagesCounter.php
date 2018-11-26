<?php

namespace application\models;

use application\core\base\Model;

class SaveMessagesCounter extends Model {

	public function saveUsersMessages($login, $hisLogin) {
		if (empty($login) || empty($hisLogin)) {
			exit;
		}
		$login = json_decode(JWT::decode($login, "MOXghJK2dJ"), true);
		$this->table = "likes";
		$findCounter = $this->findOne($login['name'], "login");
		$tmpCounter = $findCounter[0]['messages'] + 1;
		$this->updateMessagesCounter($tmpCounter, $login['name']);

		if (!$this->findPersonalMessagesCounter($hisLogin, $login['name'])) {
			$insertArray = [$hisLogin, $login['name'], 1];
			$this->insertMessagesCounter($insertArray);
		} else {
			$getCounter = $this->findPersonalMessagesCounter($hisLogin, $login['name']);
			$counter = $getCounter[0]['count'] + 1;
			$this->updatePersonalMessagesCounter($counter, $hisLogin, $login['name']);
		}
		echo $tmpCounter;
		exit;
	}

	public function saveUsersPersonalMessages($login, $hisLogin) {
		if (empty($login) || empty($hisLogin)) {
			exit;
		}
		$login = json_decode(JWT::decode($login, "MOXghJK2dJ"), true);
		if (!$this->findPersonalMessagesCounter($hisLogin, $login['name'])) {
			$insertArray = [$hisLogin, $login['name'], 1];
			$this->insertMessagesCounter($insertArray);
			echo 1;
			exit;
		} else {
			$getCounter = $this->findPersonalMessagesCounter($hisLogin, $login['name']);
			$counter = $getCounter[0]['count'] + 1;
			$this->updatePersonalMessagesCounter($counter, $hisLogin, $login['name']);
			echo $counter;
			exit;
		}
		exit;
	}
}