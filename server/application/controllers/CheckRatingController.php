<?php

namespace application\controllers;

use \application\models\CheckRating;

class CheckRatingController extends AppController {
	
	public function __construct($route) {
		parent::__construct($route);
	}

	public function checkRatingAction() {
		$model = new CheckRating();
		$model->checkRating($_POST['login']);
	}

	public function returnRatingAction() {
		$model = new CheckRating();
		$model->returnRating($_POST['userLogin']);
	}

		public function returnRatingAfterFillingAction() {
		$model = new CheckRating();
		$model->returnRatingAfterFilling($_POST['userLogin']);
	}

}