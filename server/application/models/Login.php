<?php

namespace application\models;

use application\core\base\Model;

class Login extends Model {

    public function signInVerifyAJAX($email, $password) {
    	if (empty($email) || empty($password)) {
            exit("Wrong login or password!");
        }
        $this->table = 'base_registration_data';
        $findUser = $this->findOne($email, "email");
        if (count($findUser) && !strcmp($findUser[0]['email'], $email)) {
            if ($findUser[0]['password'] && password_verify($password, $findUser[0]['password'])) {
                if ((count($checkConfirm = $this->findOne($email, "email"))) == 1) {
                    if ($checkConfirm[0]['confirmationEmail'] == 0) {
                    	echo "Not confirmed!";
                        exit;
                    }
                }
            } else {
            	echo "Wrong login or password!";
                exit;
            }
        }else {
        	echo "Wrong login or password!";
            exit;
        }
        $status = 1;
        date_default_timezone_set('Europe/Kiev');
        $currentTime = "\"" .  date('d-m-Y') . "/" . date('H:i') . "\"";
        $this->updateOnlineStatus($status, $findUser[0]['login']);
        $this->updateLoginTime($currentTime, $findUser[0]['login']);
        $this->updateLogoutTime("''", $findUser[0]['login']);
        print_r(json_encode(["name" => $findUser[0]['login']]));
        exit;
    }
}