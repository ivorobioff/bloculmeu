<?php
header('Content-Type: text/html; charset=utf-8');

ini_set('display_errors', 'On');
error_reporting(E_ALL);

session_start();

define('BASE_DIR', __DIR__);

include_once '/config/defaults.php';
include_once '/sys/autoloader.php';
include_once '/sys/shortcuts.php';

$url_path = $_SERVER['REQUEST_URI'];

$url_parts = explode('?', $url_path);

$url_path = always_set($url_parts, 0, '');
$url_path = trim(trim($url_path), '/');

$url_query = always_set($url_parts, 1, '');

$url_query_array = array();
parse_str($url_query, $url_query_array);

$url_array = array();
if ($url_path)
{
	$url_array = explode('/', $url_path);
}

$controller_name = always_set($url_array, 0,  $defaults_config['location']['controller']);
$action_name = always_set($url_array, 1,  $defaults_config['location']['action']);
$action_name = str_replace('-', '', $action_name);


$_GET = array_merge($_GET, $url_query_array);
$_GET['controller'] = $controller_name;
$_GET['action'] = $action_name;

if (!file_exists(BASE_DIR.'/controllers/'.strtolower($controller_name).'.php'))
{
	include_once '/sys/404.php';

	return ;
}

$controller_class = 'Controllers_'.ucfirst($controller_name);

if (!class_exists($controller_class))
{
	include_once '/sys/404.php';

	return ;
}

$controller_object = new $controller_class();

if (!method_exists($controller_object, $action_name))
{
	include_once '/sys/404.php';

	return ;
}

$controller_object->{$action_name}();