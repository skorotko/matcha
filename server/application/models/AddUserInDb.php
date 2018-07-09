<?php
/**
 * Created by PhpStorm.
 * User: skorotko
 * Date: 7/7/18
 * Time: 12:18 PM
 */

namespace application\models;


class AddUserInDb extends ModelsConroller
{
    public $table = "users_profile";

    public function controlAddUser(){
        $this->addUser();
        $this->searchHashTags();
    }

    public function searchHashTags(){
        preg_match_all("/([#^]{1}[a-zA-Z0-9]{1,15}[\s$])|([#^]{1}[a-zA-Z0-9]{1,15})|([#^]{1}[А-Яа-я0-9]{1,15}[\s$])|([#^]{1}[А-Яа-я0-9]{1,15})/", $_POST['hobby'], $array);
        if(count($array[0]) !== 0){
            foreach ($array[0] as $value) {
                $this->addHesh($value);
            }
        }else{exit;}
    }

    public function addUser(){
        $params = [$_POST['photo'], $_POST['first_name'], $_POST['last_name'], $_POST['gender'], $_POST['sexual_pref'], $_POST['biography'], $_POST['hobby']];
        $params[0] = $this->createPhoto($params[0]);
        $this->checkFirstName($params[1]);
        $this->checkSecondName($params[2]);
        $this->addUserProfile($params);
    }

    public function checkFirstName($firstName){
        preg_match("/([A-Z^][A-z\-]{1,})|([А-Я^][А-я\-]{1,})/", $firstName, $array);
        if(count($array[0]) !== 0){
            return;
        }else{exit;}
    }

    public function checkSecondName($secondName){
        preg_match("/([A-Z^][A-z\-]{1,})|([А-Я^][А-я\-]{1,})/", $secondName, $array);
        if(count($array[0]) !== 0){
            return;
        }else{exit;}
    }

    public function createPhoto($photo){
        $img = $photo;
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $img = base64_decode($img);
        $img1 = imagecreatefromstring($img);
        header('Content-type: image/jpeg');
        $img = uniqid() . '.jpeg';
        imagejpeg($img1, "images_users/$img");
        $photo = '/images_users/' . $img;
        return($photo);
    }
    public function addHesh($hashTags){
        $hash = ['lol', $hashTags];
        $this->table = "hash_tags";
        $this->addUserHashTags($hash);
    }
}