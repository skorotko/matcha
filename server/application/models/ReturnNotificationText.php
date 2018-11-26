<?php

namespace application\models;

use application\core\base\Model;

/**
* ReturnNotificationText is called when notification button clicked.
*
* When user click on "notification" button we should read file with notifications for current 
* user. This file is saved in '/public/history/notification' path on the server if notifications
* for user are actual at this moment. 
*
* @author   Vitalii Sarapin <vsarapin@student.unit.ua>
* @access   public
*/
class ReturnNotificationText extends Model {
    /**
    * Read notifications from file.
    * 
    * @param  string $login token from frontend, need to be decoded using JWT class
    * @access public
    * @return string formated notifications with html-tags for vuejs that returns 
    * in axios promise
    */
	public function readNotificationFile($login) {
		if (empty($login)) {
			exit;
		}
		$userName = json_decode(JWT::decode($login, "MOXghJK2dJ"), true);
		$dir	  = $userName['name'];
		$file 	  = $userName['name'] . ".txt";
		if (file_exists(WWW . "/history/notifications/$dir/allNotifications.txt")) {
			$notifications = file_get_contents(WWW . "/history/notifications/$dir/allNotifications.txt");
			echo $notifications;
			exit;
		} else {
			echo "empty";
			exit;
		}
	}
}