<?php

namespace application\core\base;

use \application\core\Db;

abstract class Model {

    protected $pdo;
    public $table;
    protected $pk = 'id';

    public function __construct() {
        $this->pdo = Db::instance();
    }

    public function query($sql) {
        return $this->pdo->execute($sql);
    }

    public function findAll() {
        $sql = "SELECT * FROM {$this->table}";
        return $this->pdo->query($sql);
    }

    public function findOne($id, $field = '') {
        $field = $field ?: $this->pk;
        $sql = "SELECT * FROM {$this->table} WHERE $field=? LIMIT 1";
        return $this->pdo->query($sql, [$id]);
    }

    public function insertRegistrationData($params) {
        $sql = "INSERT INTO base_registration_data (login, password, email, confirmationHash) VALUES (?,?,?,?)";
        $this->pdo->execute($sql, $params);
    }
    public function updateUserRating($rating, $login) {
        $sql = "INSERT INTO base_registration_data (rating, password, email, confirmationHash) VALUES (?,?,?,?)";
        $this->pdo->execute($sql, $params);
    }

    public function updateConfirmStatus($hash) {
        $hash = "\"" . $hash . "\"";
        $sql  = "UPDATE base_registration_data SET confirmationEmail=1, confirmationHash=' ' WHERE confirmationHash=$hash";
        return $this->pdo->execute($sql);
    }

    public function updateOne($rating, $login) {
        $login = "\"" . $login . "\"";
        $sql   = "UPDATE base_registration_data SET rating=$rating WHERE login=$login";
        return $this->pdo->execute($sql);
    }

    public function updateSeenUsers($user, $login) {
        $login = "\"" . $login . "\"";
        $user = "\"" . $user . "\"";
        $sql   = "UPDATE users_profile SET SeenUsers=$user WHERE login=$login";
        return $this->pdo->execute($sql);
    }

    public function updateRecoveryPassword($mail, $password) {
        $password = "\"" . $password . "\"";
        $mail = "\"" . $mail . "\"";
        $sql   = "UPDATE base_registration_data SET password=$password WHERE email=$mail";
        return $this->pdo->execute($sql);
    }

    public function updateOnlineStatus($status, $login) {
        $login = "\"" . $login . "\"";
        $sql   = "UPDATE base_registration_data SET onlineStatus = $status WHERE login = $login";
        return $this->pdo->execute($sql);
    }

    public function updateLogoutTime($time, $login) {
        $login = "\"" . $login . "\"";
        $sql   = "UPDATE base_registration_data SET logoutTime = $time WHERE login = $login";
        return $this->pdo->execute($sql);
    }

    public function updateLoginTime($time, $login) {
        $login = "\"" . $login . "\"";
        $sql   = "UPDATE base_registration_data SET loginTime = $time WHERE login = $login";
        return $this->pdo->execute($sql);
    }

    public function addUserProfile($params = []){
        $sql = "INSERT INTO users_profile (login, photo, first_name, last_name, gender, sexual_pref, birthday, biography, hobby, location, city, children, height, education, attitude, rating) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        return $this->pdo->execute($sql, $params);
    }

    public function addUserHashTags($params = []){
        $sql = "INSERT INTO hash_tags (login, hash_tags) VALUES (?,?)";
        return $this->pdo->execute($sql, $params);
    }

    public function addBlockedUser($login, $blocked) {
        $blocked = "\"" . $blocked . "\"";
        $login   = "\"" . $login . "\"";
        $sql     = "UPDATE users_profile SET blockedUsers = $blocked WHERE login = $login";
        return $this->pdo->execute($sql);
    }

    public function filterByQuery($startRaiting, $endRating, $children, $education, $startHeight, $endHeight, $preferences) {
        $preferences  = "\"" . $preferences . "\"";
        $sql          = "SELECT * FROM users_profile WHERE (rating BETWEEN $startRaiting AND $endRating) 
        AND (children = $children) 
        AND (education = $education) 
        AND (height BETWEEN $startHeight AND $endHeight) 
        AND (sexual_pref = $preferences)";

        return $this->pdo->query($sql);
    }

    public function createLikes($params = []) {
        $sql = "INSERT INTO likes (login) VALUES (?)";
        return $this->pdo->execute($sql, $params);
    }

    public function updateLikes($value, $login) {
        $login      = "\"" . $login . "\"";
        $sql        = "UPDATE likes SET notifications = $value WHERE login = $login";
        return $this->pdo->execute($sql);
    }

    public function updateLikedUsers($value, $login) {
        $login      = "\"" . $login . "\"";
        $value      = "\"" . $value . "\"";
        $sql        = "UPDATE likes SET liked_users = $value WHERE login = $login";
        return $this->pdo->execute($sql);
    }
    public function concatLikesLogins($login, $likedUsers) {
        $login      = "\"" . $login . "\"";
        $likedUsers = "\"" . $likedUsers . "\"";
        $sql        = "UPDATE likes SET liked_users = CONCAT(liked_users, $likedUsers) WHERE login = $login";
        return $this->pdo->execute($sql);
    }

    public function resetNotificationsInDb($login) {
        $login      = "\"" . $login . "\"";
        $sql        = "UPDATE likes SET notifications = 0 WHERE login = $login";
        return $this->pdo->execute($sql);
    }

    public function resetMessagesInDb($login) {
        $login      = "\"" . $login . "\"";
        $sql        = "UPDATE likes SET messages = 0 WHERE login = $login";
        return $this->pdo->execute($sql);
    }

    public function findPersonalMessagesCounter($login, $nextLogin) {
        $login      = "\"" . $login . "\"";
        $nextLogin   = "\"" . $nextLogin . "\"";
        $sql        = "SELECT * FROM personal_likes WHERE from_user = $login AND to_user = $nextLogin LIMIT 1";
        return $this->pdo->query($sql);
    }
    public function updateMessagesCounter($value, $login) {
        $login      = "\"" . $login . "\"";
        $sql        = "UPDATE likes SET messages = $value WHERE login = $login";
        return $this->pdo->execute($sql);
    }

    public function updatePersonalMessagesCounter($value, $login, $nextLogin) {
        $login      = "\"" . $login . "\"";
        $nextLogin   = "\"" . $nextLogin . "\"";
        $sql        = "UPDATE personal_likes SET count = $value, from_user = $login, to_user = $nextLogin WHERE from_user = $login";
        return $this->pdo->execute($sql);
    }

    public function insertMessagesCounter($params = []) {
        $sql        = "INSERT INTO personal_likes (from_user, to_user, count) VALUES (?,?,?)";
        return $this->pdo->execute($sql, $params);
    }

    public function enlargeRatingInProfile($rating, $login) {
        $login      = "\"" . $login . "\"";
        $sql        = "UPDATE base_registration_data SET rating = $rating WHERE login = $login";
        return $this->pdo->execute($sql);
    }

    public function enlargeRatingInRegistrationData($rating, $login) {
        $login      = "\"" . $login . "\"";
        $sql        = "UPDATE users_profile SET rating = $rating WHERE login = $login";
        return $this->pdo->execute($sql);
    }
    public function updateInformationDB ($input_params, $new_params, $login){
        $sql = "UPDATE {$this->table} SET $input_params=$new_params WHERE login=$login";
        return $this->pdo->execute($sql);
    }

    public function deleteHashTags ($login){
        $sql =  "DELETE hash_tags FROM hash_tags WHERE login = $login";
        return $this->pdo->execute($sql);
    }

    public function searchHashTagsDB ($login){
        $sql =  "SELECT * FROM hash_tags WHERE login = $login";
        return $this->pdo->query($sql);
    }

    public function updateLoginDB ($new_login, $old_login){
        $sql = "UPDATE {$this->table} SET login=$new_login WHERE login={$old_login}";
        return $this->query($sql);
    }

    public function updateLoginLikeDB ($new_login, $old_login){
        $sql = "UPDATE likes SET liked_users = REPLACE(liked_users, $old_login, $new_login)";
        return $this->query($sql);
    }

    public function addComas($params = []) {
        $sql = "INSERT INTO all_profile_photos (login, path) VALUES (?,?)";
        return $this->pdo->execute($sql, $params);
    }
}
