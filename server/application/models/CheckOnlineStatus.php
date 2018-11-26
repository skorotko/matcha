<?php

namespace application\models;

use \application\core\base\Model;
use \application\models\JWT;

class CheckOnlineStatus extends Model {

	public function CheckStatusOnOff($token) {
                if (!isset($token)) {
                        exit;
                }
                $userName = json_decode(JWT::decode($token, "MOXghJK2dJ"), true);
                $this->table = "base_registration_data";
                $checkStatus = $this->findOne($userName['name'], "login");
                if (count($checkStatus)) {
                        if ($checkStatus[0]['onlineStatus'] == 1) {
                                echo json_encode("online");
                                exit;
                        }else {
                                echo json_encode("offline");
                                exit;
                        }
                }
        }
}