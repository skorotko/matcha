<?php

namespace application\controllers;

use \application\models\GetMatches;

class GetMatchesController extends AppController {
	
	function __construct($route) {
		parent::__construct($route);
	}

	public function getMatchesAction() {
		$model = new GetMatches();
		$model->getMatches($_POST['login']);
	}
}