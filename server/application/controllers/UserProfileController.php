<?php
/**
 * Created by PhpStorm.
 * User: skorotko
 * Date: 7/6/18
 * Time: 2:41 PM
 */

namespace application\controllers;

use \application\models\AddUserInDb;
use application\models\CheckFSNameAjax;

class UserProfileController extends AppController{

    public function __construct($route) {
        parent::__construct($route);

    }
    public function fillingInUserProfileAction(){
        session_start();
        $model = new AddUserInDb();
        $model->controlAddUser();
    }

    public function ajaxCheckAction(){
        $model = new CheckFSNameAjax();
        $model->switchFS();
    }
}