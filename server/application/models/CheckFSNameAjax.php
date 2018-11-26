<?php

namespace application\models;

use \application\core\base\Model;

class CheckFSNameAjax extends Model {
    public function __construct() {
        parent::__construct();
        $_POST = json_decode(file_get_contents('php://input'), true);
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST,GET,OPTIONS');
        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
    }

    public function switchFS() {
        if(isset($_POST['firstName'])){
            $this->checkFirstName($_POST['firstName']);
        }else if(isset($_POST['secondName'])){
            $this->checkSecondName($_POST['secondName']);
        }else{
            echo 'Incorrect! Field is empty';
            exit;
        }
    }
    
    public function checkFirstName($firstName) {
        preg_match("/([A-Z^][A-z\-]{1,})|([А-Я^][А-я\-]{1,})/u", $firstName, $array);
        if (isset($array[0])) {
            if(!strcmp($firstName, $array[0])){
                echo "";
                exit;
            } else {
            $answer = "Name rules:<br>Capital letter at the beginning<br>Can contain latin or cyrillic letters and \"-\"";
            echo $answer;
            exit;
        }
    } else {
        $answer = "Name rules:<br>Capital letter at the beginning<br>Can contain latin or cyrillic letters and \"-\"";
        echo $answer;
        exit;
    }
}
    public function checkSecondName($secondName) {
        preg_match("/([A-Z^][A-z\-]{1,})|([А-Я^][А-я\-]{1,})/u", $secondName, $array);
        if (isset($array[0])) {
            if(!strcmp($secondName, $array[0])){
                echo "";
                exit;
            } else {
                $answer = "Name rules:<br>Capital letter at the beginning<br>Can contain latin or cyrillic letters and \"-\"";
                echo $answer;
                exit;
            }
        } else {
            $answer = "Name rules:<br>Capital letter at the beginning<br>Can contain latin or cyrillic letters and \"-\"";
            echo $answer;
            exit;
        }
    }
}