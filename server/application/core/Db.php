<?php

namespace application\core;


class Db {

    protected $pdo;
    protected static $instance;
    public static $queries = [];

    protected function __construct() {
        $db = require_once APP . '/config/database.php';
        $options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ];
        $this->pdo = new \PDO($db['dsn'], $db['user'],   $db['pass'], $options);
        $sql = " SELECT COUNT(*) FROM information_schema.SCHEMATA WHERE SCHEMA_NAME LIKE \"matcha\"";
        $trash = $this->query($sql);
        if (!$trash[0]['COUNT(*)']) {
            $sql = "CREATE DATABASE matcha";
            $this->execute($sql);
            $sql = "USE matcha";
            $this->execute($sql);
            $sql = require_once APP . '/config/setup.php';
            $this->execute($sql);
        }else {
            $sql = "USE matcha";
            $this->execute($sql);
        }
    }

    public static function instance() {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function execute($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }


    public function query($sql, $params = []) {
        self::$queries[] = $sql;
        $stmt = $this->pdo->prepare($sql);
        $res = $stmt->execute($params);
        if ($res !== false) {
            return $stmt->fetchAll();
        }
        return [];
    }
}