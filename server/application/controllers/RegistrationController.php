<?php

namespace application\controllers;

use \application\models\Registration;

class RegistrationController extends AppController {

    public function __construct($route) {
        parent::__construct($route);
        session_start();
    }

    public function indexAction() {
    }

    public function registrationAction() {
        $model = new Registration();
        $model->registration($_POST['registerLogin'], $_POST['registerPassword'], $_POST['registerRepassword'], $_POST['registerEmail']);
    }

    public function checkLoginAJAXAction() {
         $model = new Registration();
         $model->checkExistsLogin($_POST['registerLogin']);
     }

    public function checkMailAJAXAction() {
         $model = new Registration();
         $model->checkExistsMail($_POST['registerMail']);
     }

     public function checkPasswordAJAXAction() {
         $model = new Registration();
         $model->checkPasswords($_POST['registerPassword'], $_POST['registerRePassword']);
     }
}

