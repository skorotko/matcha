<?php

namespace application\models;

use \application\core\base\Model;

class ReturnViewProfileNotification extends Model {

	private $me, $you = '';

	public function __construct($userSeeProfile) {
		parent::__construct();
		$whoClick 				= json_decode(JWT::decode($userSeeProfile[0], "MOXghJK2dJ"), true);
		$whomClick				= trim($userSeeProfile[1]);
		$this->me 				= $whoClick['name'];
		$this->you				= $whomClick;
	}

	public function returnProfileNotification() {
		if ($this->me && $this->you) {

			//Check blocked user or not for excluding him in my notifications
			$blockedUsers = null;
			$this->table = "users_profile";
			$myProfile = $this->findOne($this->you, "login");

			$blockedUsers = $myProfile[0]['blockedUsers'];

			if (!is_null($blockedUsers)) {
				$blockedUsers = array_unique(explode(".", $blockedUsers));
				if (in_array($this->me, $blockedUsers)) {
					$returnedMessage = json_encode([
						"myName"		  => "",
						"name" 			  => ""
					]);
					echo $returnedMessage;
					exit;
				}
			}

			$this->table 		 = "likes";
			$countLikesMessages  = $this->findOne($this->you, "login");
			$tmpCountLikes		 = $countLikesMessages[0]['notifications'] + 1;
			$this->updateLikes($tmpCountLikes, $this->you);
			if (!file_exists(WWW . "/history/notifications/$this->you")) {
				mkdir(WWW . "/history/notifications/$this->you");
			}
			if (!file_exists(WWW . "/history/notifications/$this->you/allNotifications.txt")) {
				$fd  = fopen(WWW . "/history/notifications/$this->you/allNotifications.txt", 'w');
				$rewriteFile = file_get_contents(WWW . "/history/notifications/$this->you/allNotifications.txt");
			} else {
				$rewriteFile = file_get_contents(WWW . "/history/notifications/$this->you/allNotifications.txt");
				$fd = fopen(WWW . "/history/notifications/$this->you/allNotifications.txt",'w');
			}
			$text = "<li>Your profile has been seen by $this->me!</li><br>" . $rewriteFile;
			fwrite($fd, $text);
			$returnedMessage = json_encode([
				"name" 			 => $this->you,
				"messages" 		 => $countLikesMessages[0]['messages'],
				"notifications"  => $countLikesMessages[0]['notifications'],
				"message"		 => "Your profile has been seen by $this->me!"]);
			fclose($fd);
			$this->table 		 = "base_registration_data";
			$rating				 = $this->findOne($this->you, "login");
			$this->enlargeRatingInProfile($rating[0]['rating'] + 1, $this->you);
			$this->enlargeRatingInRegistrationData($rating[0]['rating'] + 1, $this->you);

			$this->table = "users_profile";
			$seenUsers = $this->findOne($this->me, "login");
			if ($seenUsers[0]['SeenUsers']) {
				$seenUsersInsert = '';
				$seenUsers[0]['SeenUsers'] = explode('.', $seenUsers[0]['SeenUsers']);
				$seenUsers[0]['SeenUsers'] = array_filter($seenUsers[0]['SeenUsers'], function($element) {
					return !empty($element);
				});
				if (count($seenUsers[0]['SeenUsers']) >= 5) {
					array_shift($seenUsers[0]['SeenUsers']);
					foreach ($seenUsers[0]['SeenUsers'] as $key => $value) {
						$seenUsersInsert = $seenUsersInsert . "." . $value;
					}
					$seenUsersInsert = $seenUsersInsert . "." . $this->you;
					$this->updateSeenUsers($seenUsersInsert, $this->me);
				} else {
					foreach ($seenUsers[0]['SeenUsers'] as $key => $value) {
						$seenUsersInsert = $seenUsersInsert . "." . $value;
					}
					$seenUsersInsert = $seenUsersInsert . "." . $this->you;
					$this->updateSeenUsers($seenUsersInsert, $this->me);
				}
			} else {
				$seenUsersInsert = "." . $this->you;
				$this->updateSeenUsers($seenUsersInsert, $this->me);
			}
			echo $returnedMessage;
			exit;
		} else {
			exit("error in model->ReturnViewProfileNotification, <br> method->returnProfileNotification");
		}
	}
}