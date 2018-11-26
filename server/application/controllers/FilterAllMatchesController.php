<?php

namespace application\controllers;

use \application\models\FilterAllMatches;

class FilterAllMatchesController extends AppController {

	function __construct($route) {
		parent::__construct($route);
	}

	public function filterAllMatchesAction() {
		$filterModel = new FilterAllMatches();
		$filterModel->FilterAllMatches($_POST['login'], $_POST['distance'], $_POST['age'], $_POST['rating'], $_POST['tags'], $_POST['children'], $_POST['preferences'], $_POST['height'], $_POST['education']);
	}
}