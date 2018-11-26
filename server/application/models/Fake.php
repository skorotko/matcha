<?php

namespace application\models;

use \application\core\base\Model;

class Fake extends Model {

	public function sendFake($login) {
		$adminMail = ["forjobaccss4@gmail.com", "korotkovsergey96@gmail.com"];
		$this->sendMail($login, $adminMail);
	}

	private function sendMail($login, $mail) {
        $encoding = "utf-8";
        $from_name = "Check user";
        $from_mail = "vsarapin@student.unit.ua, skorotko@student.unit.ua";
        $mail_subject = "Check fake user";
        $mail_message = $login . " was reported as a fake account";
        $subject_preferences = array(
            "input-charset" => $encoding,
            "output-charset" => $encoding,
            "line-length" => 76,
            "line-break-chars" => "\r\n"
        );
        $header = "Content-type: text/html; charset=".$encoding." \r\n";
        $header .= "From: " . $from_name . " <" . $from_mail . "> \r\n";
        $header .= "MIME-Version: 1.0 \r\n";
        $header .= "Content-Transfer-Encoding: 8bit \r\n";
        $header .= "Date: ".date("r (T)")." \r\n";
        $header .= iconv_mime_encode("Subject", $mail_subject, $subject_preferences);
        if ($login) {
        	mail($mail[0], $mail_subject, $mail_message, $header);
        }
        if ($login) {
       	    mail($mail[1], $mail_subject, $mail_message, $header);
    	}
	}
}