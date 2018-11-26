<?php

namespace application\controllers;

use \application\models\FilterBestMatches;
use \application\models\FilterForBestMatchesDuplicate;

class FilterBestMatchesController extends AppController {

	function __construct($route) {
		parent::__construct($route);
	}

	public function filterBestMatchesAction() {
		$model = new FilterForBestMatchesDuplicate();
		$userArray = $model->getMatches($_POST['login']);
		$filterModel = new FilterBestMatches();
		$filterModel->FilterBestMatches($userArray, $_POST['distance'], $_POST['age'], $_POST['rating'], $_POST['tags']);
	}
}