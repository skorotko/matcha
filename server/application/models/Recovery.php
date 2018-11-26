<?php

namespace application\models;

use \application\core\base\Model;

class Recovery extends Model {

	public function passwordRecovery($mail) {
		$this->table = "base_registration_data";
		$findMail 	 = $this->findOne($mail, "email");
		if (count($findMail)) {
			$password = $this->genpass(8, 2);
			$this->sendMail($password, $mail);
			$password = password_hash($password, PASSWORD_DEFAULT);
			$this->updateRecoveryPassword($mail, $password);
		}
	}

	private function genpass($number, $param = 1) {
		$arr = array('a','b','c','d','e','f',
			'g','h','i','j','k','l',
			'm','n','o','p','r','s',
			't','u','v','x','y','z',
			'A','B','C','D','E','F',
			'G','H','I','J','K','L',
			'M','N','O','P','R','S',
			'T','U','V','X','Y','Z',
			'1','2','3','4','5','6',
			'7','8','9','0','.',',',
			'(',')','[',']','!','?',
			'&amp;','^','%','@','*','$',
			'&lt;','&gt;','/','|','+','-',
			'{','}','`','~');

		// Generate password
		$pass = "";
		for($i = 0; $i < $number; $i++) {
				if ($param > count($arr) - 1) $param = count($arr) - 1;
				if ($param == 1) $param = 48;
				if ($param == 2) $param = 58;
				if ($param == 3) $param = count($arr) - 1;

				// Вычисляем случайный индекс массива
				$index = rand(0, $param);
				$pass .= $arr[$index];
			}
			return $pass;
		}

	private function sendMail($password, $mail) {
        $encoding = "utf-8";
        $from_name = "Recovery";
        $from_mail = "vsarapin@student.unit.ua, skorotko@student.unit.ua";
        $mail_subject = "Password recovery";
        $mail_message = "Your new password is $password";
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
        mail($mail, $mail_subject, $mail_message, $header);
    }
	}