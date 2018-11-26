<?php
namespace application\models;

use application\core\base\Model;

class Registration extends Model {
    protected $login;
    protected $password;
    protected $email;
    protected $hash;
    protected $ip;
    protected $loginMessage;

    public function registration($login, $password, $repassword, $email) {
        if (empty($login) ||
            empty($password) ||
            empty($email) ||
            empty($repassword)) {
            exit("Вы ввели не всю информацию, вернитесь назад и заполните все поля!");
        }
        $this->table = 'user';
        $this->login = trim(htmlspecialchars(stripslashes($login)));
        if (($checkLogin = $this->checkLoginRegular($this->login)) === false) {
            exit($this->loginMessage);
        }
        if ($password != $repassword) {
            exit("Пароли не совпадают!");
        }
        if (!preg_match("/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/", $password)) {
            exit("Пароль должен состоять минимум" . "<br>" . " из 8 символов, одной цифры, одной буквы" . "<br>" . "в верхнем регистре и одной в нижнем");
        }
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        $this->repassword = password_hash($repassword, PASSWORD_DEFAULT);
        if (filter_var($email, FILTER_VALIDATE_EMAIL))
            $this->email = $email;
        else
            exit("Неверный формат email");
        $this->checkLoginMailDb();
        $this->hash = sha1(uniqid($login, true));
        $params = [$this->login, $this->password, $this->email, $this->hash];
        $this->insertRegistrationData($params);
        $paramsTmp = [$this->login, ",,,,"];
        $this->addComas($paramsTmp);
        $this->sendMail();
        exit;
    }

    public function checkExistsLogin($login) {
        $this->table = "base_registration_data";
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

    public function checkExistsMail($mail) {
        $this->table = "base_registration_data";
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

    public function checkPasswords($password, $repassword) {
        $this->table = "base_registration_data";
            header('Cache-Control: no-cache, must-revalidate');
            header('Content-type: application/json');
            header('Access-Control-Allow-Headers: Content-Type');
            header("Access-Control-Allow-Origin: *");
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

    private function sendMail() {
        $encoding = "utf-8";
        $from_name = "Registration for defence";
        $from_mail = "vsarapin@student.unit.ua, skorotko@student.unit.ua";
        $mail_subject = "Confirm Matcha Registration";
        $mail_message = "Перейдите по этой " . "<a href=" . "http://10.111.4.5:8081/confirmation/{$this->hash}" . ">" . "ссылке" . "</a>" . " для подтверждения регистрации";
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
        mail($this->email, $mail_subject, $mail_message, $header);
    }

    private function checkLoginRegular($login) {
        $len = strlen($login);
        if (empty($login)) {
            $this->loginMessage = 'Логин не может быть пустым';
            return false;
        }
        if ($len < 4 || $len > 20) {
            $this->loginMessage = 'В логине должно быть от 4 до 20 символов';
            return false;
        }
        if (!preg_match("/^[a-zA-Z1-9]+$/", $login)) {
            $this->loginMessage = 'В логине должны быть только латинские буквы';
            return false;
        }
        if (!empty($login)) {
            if (is_numeric($login{0})) {
                $this->loginMessage = 'Логин должен начинаться с буквы';
                return false;
            }
        }
        return true;
    }

private function checkLoginMailDb() {
        $this->table = 'base_registration_data';
        $checkLogin = $this->findOne($this->login, "login");
        $checkMail = $this->findOne($this->email, "email");
        if (!empty($checkLogin)) {
            if (!strcmp($checkLogin[0]['login'], $this->login)) {
                exit("Такой логин уже занят");
            }
        }
        if (!empty($checkMail)) {
            if (!strcmp($checkMail[0]['email'], $this->email)) {
                exit("Такой email уже занят");
            }
        }
    }
}