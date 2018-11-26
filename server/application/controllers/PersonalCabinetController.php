<?php

namespace application\controllers;


use application\models\AjaxCabinet;

class PersonalCabinetController extends AppController
{

    public function ajaxSwitchAction(){
        $model = new AjaxCabinet();
        $model->switchAjax();
    }

    public function checkLoginAJAXAction() {
        $model = new AjaxCabinet();
        $model->checkExistsLogin();
    }

    public function checkFSNameAction () {
        $model = new AjaxCabinet();
        $model->switchFS();
    }

    public function checkExistsMailAction () {
        $model = new AjaxCabinet();
        $model->checkExistsMail();
    }

    public function checkPasswordsAction () {
        $model = new AjaxCabinet();
        $model->checkPasswords();
    }

    public function editProfileAction () {
        $model = new AjaxCabinet();
        $model->updateDB();
    }
}