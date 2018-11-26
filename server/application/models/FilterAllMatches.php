<?php

namespace application\models;

use application\core\base\Model;

class FilterAllMatches extends Model {

	public function FilterAllMatches($login, $distance, $age, $rating, $tags, $children, $preferences, $height, $education) {
		if (empty($login)) {
			exit;
		}
		$blockedUsers = null;
		$myLat = 0;
		$myLon = 0;
		$removeDelimiters = null;

		if (!$children) {
			$children = 0;
		} else {
			$children = 1;
		}

		if (!$education) {
			$education = 0;
		} else {
			
			$education = 1;
		}
		if (!$preferences) {
			$preferences = "Bisexual";
		}
		if ($rating[1] == 150) {
			$rating[1] = 2000000;
		}

		$userName = json_decode(JWT::decode($login, "MOXghJK2dJ"), true);

		$this->table = "hash_tags";
		$interests = $this->findAll();

		$this->table = "all_profile_photos";
		$photos = $this->findAll();

		$this->table = "likes";
		$likes = $this->findOne($userName['name'] ,"login");

		$this->table = "users_profile";
		$myProfile = $this->findOne($userName['name'], "login");


		$this->table = "base_registration_data";
		$ratings = $this->findAll();

		$blockedUsers = $myProfile[0]['blockedUsers'];
		$myLocation = explode('/', $myProfile[0]['location']);
		$myLat = $myLocation[0];
		$myLon = $myLocation[1];

		$filterArray = $this->filterByQuery($rating[0], $rating[1], $children, $education, $height[0], $height[1], $preferences);

		if (count($filterArray)) {
			foreach ($filterArray as $key => $value) {
				$filterArray[$key]['photos'] = [];
				$filterArray[$key]['fake'] = TRUE;
			}
		}
		if (count($filterArray)) {
			foreach ($filterArray as $key => $value) {
				foreach ($photos as $table => $login) {
					if (!strcmp($value['login'], $login['login'])) {
						$exploded = explode(',', $login['path']);
						$exploded = array_filter($exploded, function($element) {
							return !empty($element);
						});
						if (count($exploded)) {
							array_push($filterArray[$key]['photos'], $exploded);
						}
					}
				}
			}

			foreach ($filterArray as $profile => $user) {
				$filterArray[$profile]['interests'] = [];
			}
			foreach ($filterArray as $key => $value) {
				$login = $value['login'];
				foreach ($interests as $user => $hash_tags) {
					if (!strcmp($login, $hash_tags['login'])) {
						array_push($filterArray[$key]['interests'], $hash_tags['hash_tags']);
					}
				}
			}
		}

		foreach ($filterArray as $key => $value) {
			foreach ($ratings as $array => $searchLogin) {
				if ($searchLogin['login'] == $value['login']) {
					if ($searchLogin['onlineStatus'] == 0) {
						$filterArray[$key]['onlineStatus'] = FALSE;
					}
					if ($searchLogin['onlineStatus'] == 1) {
						$filterArray[$key]['onlineStatus'] = TRUE;
					}
					if ($searchLogin['logoutTime']) {
						$filterArray[$key]['logoutTime'] = $searchLogin['logoutTime'];
					}
				}
			}
		}
		$likedUsers = $likes[0]['liked_users'];
		if ($likedUsers) {
			$removeDelimiters = array_diff(explode('/', $likedUsers), ['/']);
			$removeDelimiters = array_filter($removeDelimiters, function($element) {
				return !empty($element);});
		}

		//Remove blocked users from result
		if (!is_null($blockedUsers)) {
			$blockedUsers = array_unique(explode(".", $blockedUsers));
			foreach ($filterArray as $key => $value) {
				foreach ($blockedUsers as $keyBlocked) {
					if ($value['login'] == $keyBlocked) {
						unset($filterArray[$key]);
					}
				}
			}
		}

		
		//Compute likable user or not
		if (!count($removeDelimiters)) {
			if (count($filterArray)) {
					foreach ($filterArray as $key => $value) {
						$filterArray[$key]['isActive'] = TRUE;
					}
				}
			} else {
				if (count($filterArray)) {
					foreach ($filterArray as $key => $value) {
						$filterArray[$key]['isActive'] = TRUE;
						foreach ($removeDelimiters as $login) {
							if (!strcmp($value['login'], $login)) {
								$filterArray[$key]['isActive'] = FALSE;
							}
						}
					}
				}
			}

		//Compute age of the user + save my Lat/Lon + unset my profile from result array
		if (count($filterArray)) {
			foreach ($filterArray as $key => $value) {
				$filterArray[$key]['birthday'] = $this->getAge($value['birthday']);
				$filterArray[$key]['block'] = FALSE;
				if ($value['login'] == $userName['name']) {
					unset($filterArray[$key]);
				}

			}
		}
		//Compute distance and push to result array
		if (count($filterArray)) {
			foreach ($filterArray as $key => $value) {
				$myLocation = explode('/', $value['location']);
				$lat2 = $myLocation[0];
				$lon2 = $myLocation[1];
				$kilometres = $this->distance($myLat, $myLon, $lat2, $lon2);
				$filterArray[$key]['distance'] =  $kilometres;
			}

			if (!is_null($tags)) {
				if (count($filterArray)) {
					foreach ($filterArray as $key => $value) {
						$filterArray[$key]['tags'] = [];
						foreach ($interests as $search => $login) {
							if (!strcmp($login['login'], $value['login'])) {
								array_push($filterArray[$key]['tags'], $login['hash_tags']); 
							}
						}
					}
					foreach ($filterArray as $key => $value) {
						if ($value['tags']) {
							$result = array_intersect($value['tags'], $tags);
							if (!count($result)) {
								unset($filterArray[$key]);
							}
						} else {
								unset($filterArray[$key]);
							}
					}
				}
			}

			if (count($filterArray)) {
			foreach ($filterArray as $key => $value) {
				if ($value['distance'] + 1 < $distance[0] || $value['distance'] > $distance[1]) {
					exit;
					unset($filterArray[$key]);
				}
				if ($value['birthday'] < $age[0] || $value['birthday'] > $age[1]) {
					unset($filterArray[$key]);
				}
				if ($value['rating'] < $rating[0] || $value['rating'] > $rating[1]) {
					unset($filterArray[$key]);
				}
			}
		}

			//Sort users by distance
			if (count($filterArray)) {
				usort($filterArray, function($a, $b) {
					return $a['distance'] <=> $b['distance'];
				});
				foreach ($filterArray as $key => $value) {
					$data = file_get_contents(WWW . $value['photo']);
					$type = pathinfo(WWW . $value['photo'], PATHINFO_EXTENSION);
					$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
					$filterArray[$key]['photo'] = $base64;
					$filterArray[$key]['seen'] = FALSE;
					htmlspecialchars_decode($filterArray[$key]['biography']);
				}
				if (count($filterArray)) {
					print_r(json_encode($filterArray));
					exit;
				}
			}
		}
		$message = "empty";
		echo $message;
		exit;
	}

	public function distance($lat1, $lon1, $lat2, $lon2) {
		$theta = $lon1 - $lon2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$kilometres = $dist * 60 * 1.1515 * 1.609344;
		return round($kilometres, 2);
	}

	public function getAge($birthDate) {
		$age = intval(date('Y', time() - strtotime($birthDate))) - 1970;
		return $age;
	}
}
