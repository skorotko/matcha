<?php

namespace application\models;

use application\core\base\Model;

/**
* Class returned counter of notifications and messages.
*
* While page is loading this clas returnes counter of notifications, messages
* and state of chat(visible/not visible).
*
* @author   Vitalii Sarapin <vsarapin@student.unit.ua>
* @access   public
*/
class CountMessagesNotifications extends Model {
    /**
    * Decode token with your login, than in Db find all necessary information
    * (counters of notifications and messages). Check existance of dir with
    *  chat and depending on it result echo appropriate message. 
    *
    * @param  string  $login token from front-end.
    * @access public
    * @return void
    */
	public function returnCountMessagesNotifications($login) {
		$userName	 = json_decode(JWT::decode($login, "MOXghJK2dJ"), true);
		$this->table = "likes";
		$count 		 = $this->findOne($userName['name'], "login");
		$login = $userName['name'];
		if (file_exists(WWW . "/history/messages/$login")) {
			echo $count[0]['messages'] . "," . $count[0]['notifications'];
			exit;
		}
		echo $count[0]['messages'] . "," . $count[0]['notifications'];
		exit;
	}
}