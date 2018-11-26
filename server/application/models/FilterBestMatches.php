<?php

namespace application\models;

use application\core\base\Model;

class FilterBestMatches extends Model {

	public function FilterBestMatches($arrayToFilter, $distance, $age, $rating, $tags) {
		json_encode($arrayToFilter);

		$this->table = "hash_tags";
		$interests = $this->findAll();


		if ($rating[1] == 150) {
			$rating[1] = 2000000;
		}
		if (count($arrayToFilter)) {
			foreach ($arrayToFilter as $key => $value) {
				if ($value['distance'] + 1 < ($distance[0]) || $value['distance'] > $distance[1]) {
					unset($arrayToFilter[$key]);
				}
				if ($value['birthday'] < $age[0] || $value['birthday'] > $age[1]) {
					unset($arrayToFilter[$key]);
				}
				if ($value['rating'] < $rating[0] || $value['rating'] > $rating[1]) {
					unset($arrayToFilter[$key]);
				}
			}
			if (!is_null($tags)) {
				if (count($arrayToFilter)) {
					foreach ($arrayToFilter as $key => $value) {
						$arrayToFilter[$key]['tags'] = [];
						foreach ($interests as $search => $login) {
							if (!strcmp($login['login'], $value['login'])) {
								array_push($arrayToFilter[$key]['tags'], $login['hash_tags']); 
							}
						}
					}
					foreach ($arrayToFilter as $key => $value) {
						if ($value['tags']) {
							$result = array_intersect($value['tags'], $tags);
							if (!count($result)) {
								unset($arrayToFilter[$key]);
							}
						}
					}
				}
			}
			if (count($arrayToFilter)) {
				usort($arrayToFilter, function($a, $b) {
					return $a['distance'] <=> $b['distance'];
				});
				print_r(json_encode($arrayToFilter));
				exit;
			}
		}
		echo "empty";
		exit;
	}
}
