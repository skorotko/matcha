<?php

namespace application\models;

use \application\core\base\Model;

class FilterForBestMatchesDuplicate extends Model {
	
	public function getMatches($login) {
		if (empty($login)) {
			exit;
		}
		$matchLogin = [];
		$removeDelimiters = null;
		$blockedUsers = null;
		$resultArray = [];
		$interestsArray = [];
		$matchLogin = [];
		$myLat = 0;
		$myLon = 0;
		$myGender = '';
		$mySexPrefs = '';
		$userName = json_decode(JWT::decode($login, "MOXghJK2dJ"), true);
		$this->table = "users_profile";
		$allProfilesFromMysql = $this->findAll();

		$this->table = "base_registration_data";
		$ratings = $this->findAll();

		$this->table = "hash_tags";
		$interests = $this->findAll();
	
		$this->table = "likes";
		$likes = $this->findOne($userName['name'] ,"login");

		$this->table = "hash_tags";
		$interests = $this->findAll();

		$this->table = "all_profile_photos";
		$photos = $this->findAll();

		//Find user interests in hash_tags and unset his profile from array
		foreach ($interests as $key => $value) {
			if (!strcmp($value['login'], $userName['name'])) {
				array_push($interestsArray, $value['hash_tags']);
				unset($interests[$key]);
			}
		}

		foreach ($allProfilesFromMysql as $profile => $user) {
			$allProfilesFromMysql[$profile]['interests'] = [];
			$allProfilesFromMysql[$profile]['fake'] = TRUE;
		}

		foreach ($allProfilesFromMysql as $key => $value) {
			$allProfilesFromMysql[$key]['photos'] = [];
		}

		foreach ($allProfilesFromMysql as $key => $value) {
			foreach ($photos as $table => $login) {
				if (!strcmp($value['login'], $login['login'])) {
					$exploded = explode(',', $login['path']);
					$exploded = array_filter($exploded, function($element) {
						return !empty($element);
					});
					if (count($exploded)) {
						array_push($allProfilesFromMysql[$key]['photos'], $exploded);
					}
				}
			}
		}

		foreach ($allProfilesFromMysql as $key => $value) {
			$login = $value['login'];
			foreach ($interests as $user => $hash_tags) {
				if (!strcmp($login, $hash_tags['login'])) {
					array_push($allProfilesFromMysql[$key]['interests'], $hash_tags['hash_tags']);
				}
			}
		}
		// foreach ($interests as $key => $value) {
		// 	foreach ($interestsArray as $tag) {
		// 		$tmpTag = trim($tag);
		// 		$tmpValue = trim($value['hash_tags']);
		// 		if (!strcmp($tmpTag, $tmpValue)) {
		// 			$login = $value['login'];
		// 			foreach ($allProfilesFromMysql as $profile => $user) {
		// 				if (!strcmp($user['login'], $login)) {
		// 					array_push($allProfilesFromMysql[$profile]['interests'], $tmpValue);
		// 				}
		// 			}
		// 		}
		// 	}
		// }

		foreach ($allProfilesFromMysql as $profile => $user) {
			$counter = count($allProfilesFromMysql[$profile]['interests']);
			$allProfilesFromMysql[$profile]['tags'] = $counter;
		}
		
 		//Find users with my hash tags
		if (count($interestsArray)) {
			foreach ($interestsArray as $key) {
				trim($key);
				foreach ($interests as $index => $interest) {
					trim($interest['hash_tags']);
					if ($interest['hash_tags'] == $key) {
						array_push($matchLogin, $interest['login']);
					}
				}
			}
		}
 		if (count($matchLogin)) {
			array_push($matchLogin, $userName['name']);
			$matchLogin = array_unique($matchLogin);
			$resultArray = $allProfilesFromMysql;
			unset($allProfilesFromMysql);
			$allProfilesFromMysql = [];
			foreach ($resultArray as $key => $value) {
				foreach ($matchLogin as $savedLogin) {
					if ($value['login'] == $savedLogin) {
						array_push($allProfilesFromMysql, $resultArray[$key]);
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
			//Compute likable user or not
			if (!count($removeDelimiters)) {
				if (count($allProfilesFromMysql)) {
					foreach ($allProfilesFromMysql as $key => $value) {
						$allProfilesFromMysql[$key]['isActive'] = TRUE;
					}
				}
			} else {
				if (count($allProfilesFromMysql)) {
					foreach ($allProfilesFromMysql as $key => $value) {
						$allProfilesFromMysql[$key]['isActive'] = TRUE;
						foreach ($removeDelimiters as $login) {
							if (!strcmp($value['login'], $login)) {
								$allProfilesFromMysql[$key]['isActive'] = FALSE;
							}
						}
					}
				}
			}

		if (count($matchLogin)) {
			array_push($matchLogin, $userName['name']);
			$matchLogin = array_unique($matchLogin);
			$resultArray = $allProfilesFromMysql;
			unset($allProfilesFromMysql);
			$allProfilesFromMysql = [];
			foreach ($resultArray as $key => $value) {
				foreach ($matchLogin as $savedLogin) {
					if ($value['login'] == $savedLogin) {
						array_push($allProfilesFromMysql, $resultArray[$key]);
					}
				}
			}
		}

		//Add rating to result array
		foreach ($allProfilesFromMysql as $key => $value) {
			foreach ($ratings as $array => $searchLogin) {
				if ($searchLogin['login'] == $value['login']) {
					$allProfilesFromMysql[$key]['rating'] = $searchLogin['rating'];
					if ($searchLogin['onlineStatus'] == 0) {
						$allProfilesFromMysql[$key]['onlineStatus'] = FALSE;
					}
					if ($searchLogin['onlineStatus'] == 1) {
						$allProfilesFromMysql[$key]['onlineStatus'] = TRUE;
					}
					if ($searchLogin['logoutTime']) {
						$allProfilesFromMysql[$key]['logoutTime'] = $searchLogin['logoutTime'];
					}
					$allProfilesFromMysql[$key]['block'] = FALSE;
				}
			}
		}

		//Compute age of the user + save my Lat/Lon + unset my profile from result array
		foreach ($allProfilesFromMysql as $key => $value) {
			$allProfilesFromMysql[$key]['birthday'] = $this->getAge($value['birthday']);
			foreach ($value as $field => $insertedData) {
				if (!is_array($insertedData) && !strcmp($userName['name'], $insertedData)) {
					$myLocation = explode('/', $value['location']);
					$myLat = $myLocation[0];
					$myLon = $myLocation[1];
					$myGender = $value['gender'];
					$mySexPrefs = $value['sexual_pref'];
					$blockedUsers = $value['blockedUsers'];
					unset($allProfilesFromMysql[$key]);
				}
				if ($value['rating'] < 60) {
					unset($allProfilesFromMysql[$key]);
				}
			}
		}

		if (!is_null($blockedUsers)) {
			$blockedUsers = array_unique(explode(".", $blockedUsers));
			foreach ($allProfilesFromMysql as $key => $value) {
				foreach ($blockedUsers as $keyBlocked) {
					if ($value['login'] == $keyBlocked) {
						unset($allProfilesFromMysql[$key]);
					}
				}
			}
		}

		//Remove gender and sexual preferences that dismatch with user profile
		if (count($allProfilesFromMysql)) {
			$allProfilesFromMysql = $this->primordialResult($myGender, $mySexPrefs, $allProfilesFromMysql);
		}
		if (count($allProfilesFromMysql)) {
		//Compute distance and push to result array
			foreach ($allProfilesFromMysql as $key => $value) {
				$myLocation = explode('/', $value['location']);
				$lat2 = $myLocation[0];
				$lon2 = $myLocation[1];
				$distance = $this->distance($myLat, $myLon, $lat2, $lon2);
				$allProfilesFromMysql[$key]['distance'] =  $distance;
			}

			//Compute likable user or not
			if (!count($removeDelimiters)) {
				if (count($allProfilesFromMysql)) {
					foreach ($allProfilesFromMysql as $key => $value) {
						$allProfilesFromMysql[$key]['isActive'] = TRUE;
					}
				}
			} else {
				if (count($allProfilesFromMysql)) {
					foreach ($allProfilesFromMysql as $key => $value) {
						$allProfilesFromMysql[$key]['isActive'] = TRUE;
						foreach ($removeDelimiters as $login) {
							if (!strcmp($value['login'], $login)) {
								$allProfilesFromMysql[$key]['isActive'] = FALSE;
							}
						}
					}
				}
			}
			//Sort users by distance
			if (count($allProfilesFromMysql)) {
				usort($allProfilesFromMysql, function($a, $b){
					return $a['distance'] <=> $b['distance'];
				});
				foreach ($allProfilesFromMysql as $key => $value) {
					$data = file_get_contents(WWW . $value['photo']);
					$type = pathinfo(WWW . $value['photo'], PATHINFO_EXTENSION);
					$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
					$allProfilesFromMysql[$key]['photo'] = $base64;
					$allProfilesFromMysql[$key]['seen'] = FALSE;
				}
				if (count($allProfilesFromMysql)) {
					return $allProfilesFromMysql;
				}
			}
		}
		$message = "empty";
		return $message;
	}

	public function distance($lat1, $lon1, $lat2, $lon2) {
		$theta = $lon1 - $lon2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$kilometres = $dist * 60 * 1.1515 * 1.609344;
		return round($kilometres, 2);
	}

	public function primordialResult($gender, $sexPrefs, $userArray) {
		if ($sexPrefs == "Bisexual") {
			foreach ($userArray as $key => $value) {
				if (!strcmp($value['sexual_pref'], "Homosexual") && strcmp($gender, $value['gender'])) {
					unset($userArray[$key]);
				}
				if (!strcmp($value['sexual_pref'], "Heterosexual")) {
					unset($userArray[$key]);
				}
			}
			return $userArray;
		}
		if ($sexPrefs == "Homosexual") {
			foreach ($userArray as $key => $value) {
				if (strcmp($gender, $value['gender'])) {
					unset($userArray[$key]);
				}
				if (!strcmp($value['sexual_pref'], "Heterosexual")) {
					unset($userArray[$key]);
				}
			}
			return $userArray;
		}
		if ($sexPrefs == "Heterosexual") {
			foreach ($userArray as $key => $value) {
				if (!strcmp($gender, $value['gender'])) {
					unset($userArray[$key]);
				}
				if (!strcmp($value['sexual_pref'], "Homosexual")) {
					unset($userArray[$key]);
				}
			}
			return $userArray;
		}
	}

	public function getAge($birthDate) {
		$age = intval(date('Y', time() - strtotime($birthDate))) - 1970;
		return $age;
	}
}


