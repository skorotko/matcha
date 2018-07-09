<?php
/**
 * Created by PhpStorm.
 * User: skorotko
 * Date: 5/25/18
 * Time: 3:37 PM
 */

namespace vendor\core\base;

use \vendor\core\Db;


abstract class Model{
    protected $pdo;
    protected $table;
    protected $pk = 'id';

    public function __construct(){
        $this->pdo = Db::instance();
    }

    public function query($sql){
        return $this->pdo->execute($sql);
    }

    public function findAll(){
        $sql = "SELECT * FROM {$this->table}";
        return $this->pdo->query($sql);
    }

    public function findOne($id, $field = ''){
        $field = $field ?: $this->pk;
        $sql = "SELECT * FROM {$this->table} WHERE $field = ? LIMIT 1";
        return $this->pdo->query($sql, [$id]);
    }

    public function findBySql($sql, $params = []){
        return $this->pdo->query($sql, $params);
    }

    public function addUserProfile($params = []){
        $sql = "INSERT INTO {$this->table} (photo, first_name, last_name, gender, sexual_pref, biography, hobby) VALUES (?,?,?,?,?,?,?)";
        debug($sql);
        debug($_POST);
        return $this->pdo->execute($sql, $params);
    }

    public function addUserHashTags($params = []){
        $sql = "INSERT INTO {$this->table} (login, hash_tags) VALUES (?,?)";
        return $this->pdo->execute($sql, $params);
    }
}