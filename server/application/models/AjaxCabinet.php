<?php

namespace application\models;

use \application\core\base\Model;

class AjaxCabinet extends Model
{
    public $table = 'users_profile';
    public $DBinf = [];
    public $login;

    public function switchAjax(){
        if(isset($_POST)){
            $this->login = json_decode(JWT::decode($_POST['token_login'], "MOXghJK2dJ"), true);
            $_POST['token_login'] = $this->login['name'];
            $mail = $this->findMail($_POST['token_login']);
            $photo = $this->findPhoto($_POST['token_login']);
            $this->table = 'users_profile';
            $user = $this->findOne($_POST['token_login'], 'login');
            $data = file_get_contents(ROOT . "/public" . $user[0]['photo']);
            $user[0]['photo'] = 'data:image/' . "jpeg" . ';base64,' . base64_encode($data);
            $user[0]['mail'] = $mail;
            $user = array_merge($user[0], $photo);
            $user = $this->location($user);
            print_r(json_encode($user));
            exit();
        }
    }

    public function findMail($login){
        $this->table = 'base_registration_data';
        $mail = $this->findOne($login, 'login');
        return($mail[0]['email']);
    }

    public function location($user){
        $location = explode("/", $user['location']);
        $user['lat'] = $location[0];
        $user['lng'] = $location[1];
        return ($user);
    }

    public function findPhoto($login){
        $this->table = 'all_profile_photos';
        $photoDb = $this->findOne($login, 'login');
        $photoDb = explode(",", $photoDb[0]['path']);
        $count = 1;
        $photo = [];
        $photo_src = [];
        foreach ($photoDb as $key => $value){
            if(empty($value)){
                $photo_src['photo_user_src_' . $count] = '';
                $photo['photo_user_' . $count] = '';
                $count++;
            }else{
                $photo_src['photo_user_src_' . $count] = $value;
                $data = file_get_contents(ROOT . "/public" . $value);
                $photo['photo_user_' . $count] = 'data:image/' . "jpeg" . ';base64,' . base64_encode($data);
                $count++;
            }
        }
        $photo = array_merge($photo, $photo_src);
        if(empty($photo))
            $photo = '';
        return($photo);
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
        preg_match("/([A-Z^][A-z\-]{1,})/", $firstName, $array);
        if (isset($array[0])) {
            if(!strcmp($firstName, $array[0])){
                exit;
            } else {
                $answer = "Name rules:<br>Capital letter at the beginning<br>Can contain latin letters and \"-\"";
                echo $answer;
                exit;
            }
        } else {
            $answer = "Name rules:<br>Capital letter at the beginning<br>Can contain latin letters and \"-\"";
            echo $answer;
            exit;
        }
    }
    public function checkSecondName($secondName) {
        preg_match("/([A-Z^][A-z\-]{1,})/", $secondName, $array);
        if (isset($array[0])) {
            if(!strcmp($secondName, $array[0])){
                exit;
            } else {
                $answer = "Name rules:<br>Capital letter at the beginning<br>Can contain latin letters and \"-\"";
                echo $answer;
                exit;
            }
        } else {
            $answer = "Name rules:<br>Capital letter at the beginning<br>Can contain latin letters and \"-\"";
            echo $answer;
            exit;
        }
    }

    public function checkExistsLogin() {
        $this->table = "base_registration_data";
        $login = $_POST['login'];
        if (empty($login)) {
            echo "empty";
            exit;
        }
        else if (!$this->findOne($login, "login")) {
            $len = strlen($login);
            if ($len < 4 || $len > 20) {
                echo "1";
                exit;
            }else if (!preg_match("/^[a-zA-Z]+$/", $login)) {
                echo "2";
                exit;
            }
            echo "true";
            exit;
        }else {
            echo "false";
            exit;
        }

    }

    public function checkExistsMail() {
        $this->table = "base_registration_data";
        $mail = $_POST['mail'];
        if (empty($mail)) {
            echo "empty";
            exit;
        }
        else if (!$this->findOne($mail, "email")) {
            if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                echo "1";
                exit;
            }
            echo "true";
            exit;
        }else {
            echo "false";
            exit;
        }
    }

    public function checkPasswords() {
        $this->table = "base_registration_data";
        $password = $_POST['pass'];
        $repassword = $_POST['pass_rep'];
        if (empty($password)) {
            echo "emptyP";
            exit;
        }else if (empty($repassword)) {
            echo "emptyR";
            exit;
        }else if ($password != $repassword) {
            echo "1";
            exit;
        }else if (!preg_match("/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/", $password)) {
            echo "2";
            exit;
        }
        echo "true";
        exit;
    }

    public function createPhotoUsersDB(){
        if(empty($_POST['photo_user_1'])) {
            $path = '' . ',';
            unset($_POST['photo_user_1']);
        }else if (strripos($_POST['photo_user_1'], "/user_photos/") === 0) {
            $path = $_POST['photo_user_1'] . ',';
            unset($_POST['photo_user_1']);
        }else {
            $path = $this->createPhoto($_POST['photo_user_1']) . ',';
            unset($_POST['photo_user_1']);
        }
        if(empty($_POST['photo_user_2'])) {
            $path = $path . '' . ',';
            unset($_POST['photo_user_2']);
        }else if (strripos($_POST['photo_user_2'], "/user_photos/") === 0) {
            $path = $path . $_POST['photo_user_2'] . ',';
            unset($_POST['photo_user_2']);
        }else {
            $path = $path . $this->createPhoto($_POST['photo_user_2']) . ',';
            unset($_POST['photo_user_2']);
        }
        if(empty($_POST['photo_user_3'])) {
            $path = $path . '' . ',';
            unset($_POST['photo_user_3']);
        }else if (strripos($_POST['photo_user_3'], "/user_photos/") === 0) {
            $path = $path . $_POST['photo_user_3'] . ',';
            unset($_POST['photo_user_3']);
        }else {
            $path = $path . $this->createPhoto($_POST['photo_user_3']) . ',';
            unset($_POST['photo_user_3']);
        }
        if(empty($_POST['photo_user_4'])) {
            $path = $path . '' . ',';
            unset($_POST['photo_user_4']);
        }else if (strripos($_POST['photo_user_4'], "/user_photos/") === 0) {
            $path = $path . $_POST['photo_user_4'] . ',';
            unset($_POST['photo_user_4']);
        }else {
            $path = $path . $this->createPhoto($_POST['photo_user_4']) . ',';
            unset($_POST['photo_user_4']);
        }
        if(empty($_POST['photo_user_5'])) {
            $path = $path . '';
            unset($_POST['photo_user_5']);
        }else if (strripos($_POST['photo_user_5'], "/user_photos/") === 0) {
            $path = $path . $_POST['photo_user_5'];
            unset($_POST['photo_user_5']);
        }else {
            $path = $path . $this->createPhoto($_POST['photo_user_5']);
            unset($_POST['photo_user_5']);
        }
        return($path);
    }

    public function updateDB() {
        if(isset($_POST)){
            $post_hobby = [];
            $this->login = json_decode(JWT::decode($_POST['token_login'], "MOXghJK2dJ"), true);
            $login = $this->login['name'];
            $this->login = "\"" . $this->login['name']  . "\"";
            unset($_POST['token_login']);
            $_POST['biography'] = htmlspecialchars($_POST['biography']);
            if (count($_POST['hobby']) && $_POST['hobby'] != '') {
                $tmpPost = '';
                $post_hobby = $_POST['hobby'];
                foreach ($_POST['hobby'] as $key) {
                    $tmpPost = $tmpPost . " " . $key;
                }
                $_POST['hobby'] = $tmpPost;
            }
            if(empty($_POST['children'])){
                $_POST['children'] = 0;
            }
            if(empty($_POST['education'])){
                $_POST['education'] = 0;
            }
            if(!empty($_POST['location'])){
                $_POST['location'] = implode("/", $_POST['location']);
            }else{
                unset($_POST['location']);
            }
            if(!empty($_POST['photo'])){
                $_POST['photo'] = $this->createPhoto($_POST['photo']);
            }else{
                unset($_POST['photo']);
            }
            $path = $this->createPhotoUsersDB();
            $_POST['path'] = $path;
            $this->DBinf = $this->findOne($login, 'login');
            if(empty($_POST['password'])){
                unset($_POST['password']);
            }else{
                $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }
            $object = json_encode(["name" => $_POST['login']]);
            $mess   = JWT::encode($object, "MOXghJK2dJ");
            if($this->DBinf[0]['login'] !== $_POST['login'])
                $mess = $this->updateLoginInDB($_POST['login'], $this->DBinf[0]['login']);
            if($_POST['gender'] === 'on')
                $_POST['gender'] = 'Female';
            else
                $_POST['gender'] = 'Male';
            $str = explode("T", $_POST['birthday']);
            $_POST['birthday'] = $str[0];
            foreach ($_POST as $key => $value){
                if($key === 'path'){
                    $this->table = 'all_profile_photos';
                    $this->updateInformationDB($key, "\"" . $value  . "\"", "\"" . $this->DBinf[0]['login']  . "\"");
                    continue;
                }
                if($key === 'email' || $key == 'password') {
                    $this->table = 'base_registration_data';
                    $this->updateInformationDB($key, "\"" . $value . "\"", "\"" . $this->DBinf[0]['login'] . "\"");
                    continue;
                }
                if($key === 'hobby'){
                    $this->searchHashTags($post_hobby);
                }
                $this->table = 'users_profile';
                $this->updateInformationDB($key, "\"" . $value  . "\"", "\"" . $this->DBinf[0]['login']  . "\"");
            }
            echo $mess;
            exit;
        }
    }

    public function updateLoginInDB($new_login, $old_login){
        $object = json_encode(["name" => $new_login]);
        $mess   = JWT::encode($object, "MOXghJK2dJ");
        $new_login = "\"" . $new_login  . "\"";
        $old_login = "\"" . $old_login  . "\"";
        $array_table = ['likes', 'hash_tags', 'base_registration_data', 'all_profile_photos'];
        foreach ($array_table as $value){
            $this->table = $value;
            $this->updateLoginDB($new_login, $old_login);
        }
        $this->updateLoginLikeDB($new_login, $old_login);
        return($mess);
    }

    public function searchHashTags($array){
        $this->deleteHashTagsDB($array);
    }

    public function deleteHashTagsDB($hashTags){
        $answer = $this->searchHashTagsDB($this->login);
        if(!empty($answer))
            $this->deleteHashTags($this->login);
        if(count($hashTags) !== 0) {
            foreach ($hashTags as $value) {
                $addHash = trim($value);
                $this->addHesh($addHash);
            }
        }
    }

    public function createPhoto($photo){
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
        return($photo);
    }

    public function addHesh($hashTags){
        $hash = [$this->DBinf[0]['login'], $hashTags];
        $this->table = "hash_tags";
        $this->addUserHashTags($hash);
    }
}