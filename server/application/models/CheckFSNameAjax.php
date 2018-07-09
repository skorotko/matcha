<?php
/**
 * Created by PhpStorm.
 * User: skorotko
 * Date: 7/9/18
 * Time: 4:30 PM
 */

namespace application\models;


class CheckFSNameAjax extends ModelsConroller
{
    public function __construct()
    {
        parent::__construct();
        $_POST = json_decode(file_get_contents('php://input'), true);
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST,GET,OPTIONS');
        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
    }

    public function switchFS(){
        if(key($_POST) == "first_name"){
            $this->checkFirstName($_POST['first_name']);
        }else{
            $this->checkFirstName($_POST['second_name']);
        }
    }

    public function checkFirstName($firstName){
        preg_match("/([A-Z^][A-z\-]{1,})|([А-Я^][А-я\-]{1,})/", $firstName, $array);
        if(count($array) !== 0){
            exit;
        }else{
            echo 'Incorrect! Your First Name must be contain ... ';
            exit;
        }
    }

    public function checkSecondName($secondName){
        preg_match("/([A-Z^][A-z\-]{1,})|([А-Я^][А-я\-]{1,})/", $secondName, $array);
        if(count($array[0]) !== 0){
            exit;
        }else{
            echo 'Incorrect! Your Second Name must be contain ... ;';
        }
    }
}