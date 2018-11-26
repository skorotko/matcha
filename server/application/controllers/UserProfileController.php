<?php
namespace application\controllers;

use \application\models\AddUserInfoInDb;

use application\models\CheckFSNameAjax;

class UserProfileController extends AppController {
    public function __construct($route) {
        parent::__construct($route);
    }

    public function fillingInUserProfileAction() {
        $model = new AddUserInfoInDb();
        $model->controlAddUser();
    }

    public function ajaxCheckAction() {
        $model = new CheckFSNameAjax();
        $model->switchFS();
    }
}