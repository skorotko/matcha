<?php

namespace application\models;

use \application\core\base\Model;

class SaveMessages extends Model {

	public function saveMessages($login) {
		$whoClick  = json_decode(JWT::decode($login[0], "MOXghJK2dJ"), true);
		$whomClick = trim($login[1]);
		$me        = $whoClick['name'];
		$you       = $whomClick;
		$message   = $login[2];

		$tmpMessages = file_get_contents(WWW . "/history/messages/$me/$you.txt");
		$tmpMessages = str_replace("<span class='seen-or-not'>Delivered</span>", "", $tmpMessages);
		$tmpMessages = str_replace("<span class='seen-or-not'>Seen</span>", "", $tmpMessages);
		$tmpFd = fopen(WWW . "/history/messages/$me/$you.txt","w");
		fwrite($tmpFd, $tmpMessages);  
		fclose($tmpFd);

		$messageForMe  = "<div class='message bubble-right'>" . "<label class='message-user'>" . $me . "</label>" . "<p>$message</p></div><span class='seen-or-not'>Delivered</span>";
		$messageForYou = "<div class='message bubble-left'>" . "<label class='message-user'>" . $me . "</label>" . "<p>$message</p></div>";

		$myFd = fopen(WWW . "/history/messages/$me/$you.txt","a");  
		fwrite($myFd, $messageForMe);  
		fclose($myFd);

		$yourFd = fopen(WWW . "/history/messages/$you/$me.txt", "a");  
		fwrite($yourFd, $messageForYou);  
		fclose($yourFd);

		$returnMessage = file_get_contents(WWW . "/history/messages/$you/$me.txt");
		$returnObject = json_encode([
			"matchThisName" => $you,
			"from" => $me,
			"message" => $returnMessage
		]);
		echo $returnObject;
		exit;
	}

	public function changeSeenStatus($myLogin, $hisLogin) {
		if (empty($myLogin) || empty($hisLogin)) {
			exit;
		}
		$tmpMessages = file_get_contents(WWW . "/history/messages/$hisLogin/$myLogin.txt");
		$tmpMessages = str_replace("<span class='seen-or-not'>Seen</span>", "", $tmpMessages);
		$tmpMessages = str_replace("<span class='seen-or-not'>Delivered</span>", "<span class='seen-or-not'>Seen</span>", $tmpMessages);
		$tmpFd = fopen(WWW . "/history/messages/$hisLogin/$myLogin.txt","w");
		$this->updatePersonalMessagesCounter(0, $hisLogin, $myLogin);
		fwrite($tmpFd, $tmpMessages);  
		fclose($tmpFd);	
	}

	public function changeMessagesPersonalCounter($myLogin, $hisLogin) {
		if (empty($myLogin) || empty($hisLogin)) {
			exit;
		}
		if (!$this->findPersonalMessagesCounter($hisLogin, $myLogin)) {
			$insertArray = [$hisLogin, $myLogin, 1];
			$this->insertMessagesCounter($insertArray);
			echo 1;
			exit;
		} else {
			$getCounter = $this->findPersonalMessagesCounter($hisLogin, $myLogin);
			$counter = $getCounter[0]['count'] + 1;
			$this->updatePersonalMessagesCounter($counter, $hisLogin, $myLogin);
			echo $counter;
			exit;
		}
	}
}