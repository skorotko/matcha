<?php

namespace application\models;

use application\core\base\Model;

class Activation extends Model {
	
	public function checkConfirmUrl($hash) {
        if ($hash) {
            $this->table = 'base_registration_data';
            if ($hashWasFound = $this->findOne($hash, 'ConfirmationHash')) {
                $this->updateConfirmStatus($hash);
                $this->updateConfirmStatus($hash);
                echo "success";
                exit;
            }
            else {
            	echo "error";
                exit;
            }
    }
        else {
        	echo "error";
            exit;
        }
    }
}