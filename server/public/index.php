<?php

use application\core\Router;
use application\core\Db;

ini_set('memory_limit', '-1');
ini_set("display_errors", 1);
error_reporting(E_ALL);

define('WWW', __DIR__);
define('CORE', dirname(__DIR__) . '/application/core');
define('ROOT', dirname(__DIR__));
define('APP', dirname(__DIR__) . '/application');
define('LAYOUT', 'default');

if (!file_exists(WWW . "/history")) {
	mkdir(WWW . "/history");
	mkdir(WWW . "/history/notifications");
	mkdir(WWW . "/history/messages");
}

spl_autoload_register(function ($class) {
    $path = ROOT . '/' . str_replace('\\', '/', $class) . '.php';
    	if (file_exists($path)) {
    		require_once $path;
    	}
});
$query = rtrim($_SERVER['QUERY_STRING'], '/');

Router::add('^recovery/restore/.+?$', ['controller' => 'Recovery', 'action' => 'restore']);
Router::add('^activation/activation/.+?$', ['controller' => 'Activation', 'action' => 'activation']);

//default routes
Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');
Db::instance();
Router::dispatch($query);
