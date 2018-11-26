<?php

namespace application\models;

use application\core\base\Model;

/**
* SaveUserLikes is a class for saving likes.
*
* When user click on "like" button in profile of other user we should
* enlarge counter in DB and send this counter to the right user.
*
* @author   Vitalii Sarapin <vsarapin@student.unit.ua>
* @access   public
*/
class SaveUserLikes extends Model {
	/** 
	* @var string $me 				contains your login in Db.
	* @var string $you 				contains login of the user that you like with preceding "/" for inserting in DB table.
	* @var string $returnLikedUser	contains trimmed login of the user that you like
	*/
	private $me, $you, $returnLikedUser = '';
    /**
    * decode and set income variables.
    *
    * @param  array  $usersLikes array that consist of liked user login and who liked him.
    * @access public
    */
	public function __construct($usersLikes) {
		parent::__construct();
		$whoClick 				= json_decode(JWT::decode($usersLikes[0], "MOXghJK2dJ"), true);
		$whomClick				= trim($usersLikes[1]);
		$this->me 				= $whoClick['name'];
		$this->you				= "/" . $whomClick;
		$this->returnLikedUser  = trim($usersLikes[1]);
	}
    /**
    * saveUsersLikes method
    *
    * create, save and concatenate notifications in *.txt files for each user, calculates matches 
    * and returns the concatenation of user data.
    *
    * @access public
    * @return object concatenated name, message counter, notification counter and message
    * smth like "<name> liked you!" or in other case "You have a match with <name>".
    */
	public function saveUsersLikes() {
		if ($this->me && $this->you) {

			//Check blocked user or not for excluding him in my notifications
			$blockedUsers = null;
			$this->table = "users_profile";
			$myProfile = $this->findOne($this->returnLikedUser, "login");

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
			
			$this->concatLikesLogins($this->me, $this->you);

			$this->table 		 = "likes";
			$countLikesMessages  = $this->findOne($this->returnLikedUser, "login");

			if (!file_exists(WWW . "/history/notifications/$this->returnLikedUser")) {
				mkdir(WWW . "/history/notifications/$this->returnLikedUser");
			}
			if (!file_exists(WWW . "/history/notifications/$this->returnLikedUser/allNotifications.txt")) {
				$fd  = fopen(WWW . "/history/notifications/$this->returnLikedUser/allNotifications.txt", 'w');
				$rewriteFile = file_get_contents(WWW . "/history/notifications/$this->returnLikedUser/allNotifications.txt");
			} else {
				$rewriteFile = file_get_contents(WWW . "/history/notifications/$this->returnLikedUser/allNotifications.txt");
				$fd = fopen(WWW . "/history/notifications/$this->returnLikedUser/allNotifications.txt",'w');
			}
			if (in_array(trim($this->me), array_diff(explode('/', $countLikesMessages[0]['liked_users']), [',']))) {
				if (!file_exists(WWW . "/history/notifications/$this->me/allNotifications.txt")) {
					$myFdFile = fopen(WWW . "/history/notifications/$this->me/allNotifications.txt",'w');
					$textFromMyNotifications = "<li>You have a match with $this->returnLikedUser!</li><br>";
					fwrite($myFdFile, $textFromMyNotifications);
					fclose($myFdFile);
				}
				if (file_exists(WWW . "/history/notifications/$this->me/allNotifications.txt")) {
					$rewriteMyFile = file_get_contents(WWW . "/history/notifications/$this->me/allNotifications.txt");
					$myFdFile = fopen(WWW . "/history/notifications/$this->me/allNotifications.txt",'w');
					$textFromMyNotifications = "<li>You have a match with $this->returnLikedUser!</li><br>" . $rewriteMyFile;
					
					$this->table 			 = "likes";
					$countMyLikesMessages    = $this->findOne($this->me, "login");
					$tmpCountMyLikes		 = $countMyLikesMessages[0]['notifications'] + 1;
					$this->updateLikes($tmpCountMyLikes, $this->me);

					$this->table 			 = "likes";
					$countLikesMessages      = $this->findOne($this->returnLikedUser, "login");
					$tmpCountLikes			 = $countLikesMessages[0]['notifications'] + 1;
					$this->updateLikes($tmpCountLikes, $this->returnLikedUser);

					fwrite($myFdFile, $textFromMyNotifications);
					fclose($myFdFile);
				}
				$text = "<li>You have a match with $this->me!</li><br>" . $rewriteFile;
				fwrite($fd, $text);
				$this->createChatFiles();
				$returnedMessage = json_encode([
				"myName"		  => $this->me,
				"myNotifications" => $tmpCountMyLikes,
				"name" 			  => $this->returnLikedUser,
				"messages" 		  => $countLikesMessages[0]['messages'],
				"notifications"   => $tmpCountLikes,
				"message"		  => "You have a match with $this->me!"
			]);
			} else {
				$this->table 		 = "likes";
				$countLikesMessages  = $this->findOne($this->returnLikedUser, "login");
				$tmpCountLikes		 = $countLikesMessages[0]['notifications'] + 1;
				$this->updateLikes($tmpCountLikes, $this->returnLikedUser);
				$text = "<li>$this->me liked you!</li><br>" . $rewriteFile;
				fwrite($fd, $text);
				$returnedMessage	 = json_encode([
				"likeUser"		 => $this->me,
				"name" 			 => $this->returnLikedUser,
				"messages" 		 => $countLikesMessages[0]['messages'],
				"notifications"  => $tmpCountLikes,
				"message"		 => "$this->me liked you!"]);
			}
			fclose($fd);
			echo $returnedMessage;
			exit;
		} else {
			exit("error in model->SaveUserLikes, <br> method->saveUsersLikes");
		}
	}

	public function createChatFiles() {
		if (!file_exists(WWW . "/history/messages/$this->returnLikedUser")) {
			mkdir(WWW . "/history/messages/$this->returnLikedUser");
		}
		if (!file_exists(WWW . "/history/messages/$this->me")) {
			mkdir(WWW . "/history/messages/$this->me");
		}
		$myFd  = fopen(WWW . "/history/messages/$this->returnLikedUser/$this->me.txt", 'w');
		fclose($myFd);
		$fd  = fopen(WWW . "/history/messages/$this->me/$this->returnLikedUser.txt", 'w');
		fclose($fd);
	}

	public function saveUsersMessages() {
		
	}
}