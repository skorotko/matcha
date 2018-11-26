<?php

namespace application\models;

use \application\core\base\Model;

class AddUserInfoInDb extends Model {

    public function controlAddUser() {
        $this->addUser();
        $this->searchHashTags();
        echo TRUE;
        exit;
    }

    public function searchHashTags() {
        if(count($_POST['hobby']) && $_POST['hobby'] != ''){
            foreach ($_POST['hobby'] as $value) {
                $this->addHesh($value);
            }
        } else{
            return;
        }
    }

    public function addHesh($hashTags) {
        $userName = json_decode(JWT::decode($_POST['login'], "MOXghJK2dJ"), true);
        $hash = [$userName['name'], $hashTags];
        $this->addUserHashTags($hash);
    }
    public function addUser() {
        $hobby = null;
        $biography = null;
        $education = 0;
        $attitude = null;
        $position = null;
        $children = 0;
        $rating = 60;

        if (empty($_POST['login']) || empty($_POST['photo']) || empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['sexual_pref']) || empty($_POST['birthday']))
            exit;
        if (!empty($_POST['biography'])) {
            $rating += 10;
            $biography = htmlentities($_POST['biography']);
        }
        if (!empty($_POST['tmpHobbies'])) {
            $rating += 20;
            $hobby = htmlentities($_POST['tmpHobbies']);
        }
        if ($_POST['position'] == "/") {
            $position = $_POST['positionIfBlocked'];
        } else {
            $rating += 10;
            $position = $_POST['position'];
        }
        if (!$_POST['attitude']) {
            $attitude = "atheist";
        } else {
            $attitude = $_POST['attitude'];
        }
        if ($_POST['education']) {
            $education = 1;
        } else {
            $education = 0;
        }
        if ($_POST['children']) {
            $children = 1;
        } else {
            $children = 0;
        }
        $userName = json_decode(JWT::decode($_POST['login'], "MOXghJK2dJ"), true);
        $birthday = explode(" ", $_POST['birthday']);
        $gender = !$_POST['gender'] ? "Male" : "Female";
        $params = [$userName['name'], $_POST['photo'], $_POST['first_name'], $_POST['last_name'], $gender, $_POST['sexual_pref'], $birthday[0], $biography, $hobby, $position, $_POST['city'], $children, $_POST['height'], $education, $attitude, $rating];
        $params[1] = $this->createPhoto($params[1]);
        $this->createLikes([$userName['name']]);
        $this->updateOne($rating, $userName['name']);
        $this->checkFirstName($params[2]);
        $this->checkSecondName($params[3]);
        $this->addUserProfile($params);
    }

    public function checkFirstName($firstName) {
        preg_match("/([A-Z^][A-z\-]{1,})|([А-Я^][А-я\-]{1,})/", $firstName, $array);
        if (isset($array[0])) {
            if(!strcmp($firstName, $array[0])){
                return;
            }
        } else {
            exit;
        }
    }
    public function checkSecondName($secondName) {
        preg_match("/([A-Z^][A-z\-]{1,})|([А-Я^][А-я\-]{1,})/", $secondName, $array);
        if (isset($array[0])) {
            if(!strcmp($secondName, $array[0])){
                return;
            }
        } else {
            exit();
        }
    }

    public function createPhoto($photo) {
        if ($photo) {
            $img = $photo;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace('data:image/jpeg;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $img = base64_decode($img);
            $img1 = imagecreatefromstring($img);
            header('Content-type: image/jpeg');
            $img = uniqid() . '.jpeg';
            imagejpeg($img1, "user_photos/$img");
            $photo = '/user_photos/' . $img;
            return $photo;
        }
    }
}