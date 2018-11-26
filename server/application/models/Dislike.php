<?php
namespace application\models;

use application\core\base\Model;
/**
* Dislike is a class for removing likes.
*
* When user click on "dislike" button in profile of other user we should
* reduce counter and remove this user from table in DB and send 
* notofication about this action. Called in DislikeController.
*
* @param 	array POST array of 2 users that pass from vuejs using axios.
* @author   Vitalii Sarapin <vsarapin@student.unit.ua>
* @access   public
*/
class Dislike extends Model {

	/** 
	* @var string $me 				contains your login in Db.
	* @var string $you 				contains login of the user that you dislike.
	*/
	private $me, $you = '';
	/**
    * decode and set income variables.
    *
    * @param  array  $usersNames array that consist of disliked user login and who disliked him.
    * @access public
    */
	public function __construct($usersNames) {
		parent::__construct();
		$whoClick 				= json_decode(JWT::decode($usersNames[0], "MOXghJK2dJ"), true);
		$whomClick				= trim($usersNames[1]);
		$this->me 				= trim($whoClick['name']);
		$this->you				= $whomClick;
	}
	/**
	* Make all necessary actions for deleting like.
	*
	* First of all i find user who clicked ($this->me) "dislike" button in Db and explode 
	* users that he likes by '/' delimeter. Than delete empty values, 
	* find in this array user that i need to delete ($this->you) and 
	* save all other users except him.
	*
	* @access public
	* @return object JSON object that consist of notification counter, name of user
	* that should accept this object and message of notification.
	*/
	public function dislike() {
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

			$this->table 	     = "likes";
			$arr 			     = $this->findOne($this->me, "login");
			$likedUsers 	     = explode('/', $arr[0]['liked_users']);

			// delete empty values and target user.
			$deleteEmptyValues   = array_filter($likedUsers, function($element) {
				return $element != $this->you && !empty($element);
			});
			$likedUsersField = '';
			// concatenate remaining users using "/" delimeter and save in DB.
			foreach ($deleteEmptyValues as $key) {
				$likedUsersField = $likedUsersField . "/" . $key;
			}
			$this->updateLikedUsers($likedUsersField, $this->me);
			$this->table 		   = "likes";
			$countNotifications	   = $this->findOne($this->you, "login");
			$tmpCountNotifications = $countNotifications[0]['notifications'] + 1;
			$this->updateLikes($tmpCountNotifications, $this->you);
			$jsonReturnMessage   = json_encode([
				"hisName"		=>  $this->me,
				"name"			=>  $this->you,
				"message"       => "$this->me disliked you!",
				"notifications" => $countNotifications[0]['notifications']

			]);
			if (file_exists(WWW . "/history/messages/$this->you/$this->me.txt")) {
				unlink(WWW . "/history/messages/$this->you/$this->me.txt");
			}
			if (file_exists(WWW . "/history/messages/$this->me/$this->you.txt")) {
				unlink(WWW . "/history/messages/$this->me/$this->you.txt");
			}
			//save notification text in history of user.
			$rewriteFile = '';
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
			$textFromMyNotifications = "<li>$this->me disliked you!</li><br>" . $rewriteFile;
			fwrite($fd, $textFromMyNotifications);
			fclose($fd);
			echo $jsonReturnMessage;
		} else {
			exit ("error in Dislike.php");
		}
	}
}