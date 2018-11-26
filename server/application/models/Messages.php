<?php

namespace application\models;

use \application\core\base\Model;

class Messages extends Model {

	public function returnMessages($login) {
		$allFiles = '';
		$txtMessages = '';
		$returnedObject = [];
		$userName = json_decode(JWT::decode($login, "MOXghJK2dJ"), true);
		$login = $userName['name'];
			if (file_exists(WWW . "/history/messages/$login") && $handle = opendir(WWW . "/history/messages/$login")) {
				$count = 0;
				while (false !== ($file = readdir($handle))) {
					if ($file != "." && $file != "..") {
						$count++;
						$txtMessages = file_get_contents(WWW . "/history/messages/$login/$file");
						array_push($returnedObject, ["login" => $file, "messages" => $txtMessages]);
					}
				}
				if ($count == 0) {
					echo "empty";
					exit;
				}
				foreach ($returnedObject as $key => $value) {
					$this->table 					= "users_profile";
					$findAvatar 					= $this->findOne(substr($value['login'], 0, -4), "login");
					$findMesgCount 					= $this->findPersonalMessagesCounter(substr($value['login'], 0, -4), $login);
					$returnedObject[$key]['avatar'] = "http://10.111.4.5:8080" . $findAvatar[0]['photo'];
					$returnedObject[$key]['name'] 	= $findAvatar[0]['first_name'] . " " . $findAvatar[0]['last_name'];
					$returnedObject[$key]['login']	= substr($value['login'], 0, -4);
					$returnedObject[$key]['id']		= $findAvatar[0]['newid'];
					if (count($findMesgCount)) {
						$returnedObject[$key]['msgCnt'] = $findMesgCount[0]['count'];
						if ($returnedObject[$key]['msgCnt'] > 0) {
							$returnedObject[$key]['isActiveNotifications'] = true;
						} else {
							$returnedObject[$key]['isActiveNotifications'] = false;
						}
					} else {
						$returnedObject[$key]['msgCnt'] = 0;
						$returnedObject[$key]['isActiveNotifications'] = false;
					}
				}
				$returnedObject = json_encode($returnedObject);
				closedir($handle);
				echo $returnedObject;
				exit; 
			}
			else {
				echo "empty";
				exit;
		}
	}

	public function returnMessagesWithUser($login) {
		$whoClick  = json_decode(JWT::decode($login[0], "MOXghJK2dJ"), true);
		$whomClick = trim($login[1]);
		$me        = $whoClick['name'];
		$you       = $whomClick;

		if (file_exists(WWW . "/history/messages/$me")) {
			if (file_exists(WWW . "/history/messages/$me/$you.txt")) {
				$txtMessage = file_get_contents(WWW . "/history/messages/$me/$you.txt");
				$returnedObject = json_encode(["login" => $you, "messages" => $txtMessage]);
				echo $returnedObject;
				exit;
			} else {
				exit("empty");
			}
		} else {
			exit("empty");
		}
	}
}