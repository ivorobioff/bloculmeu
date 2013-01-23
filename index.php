<?php
define('BASE_DIR', __DIR__);

include_once '/config/defaults.php';
include_once '/sys/autoloader.php';
include_once '/sys/shortcuts.php';

if (!isset($_GET['controller']))
{
	$_GET['controller'] = $defaults_config['location']['controller'];
}

if (!isset($_GET['action']))
{
	$_GET['action'] = $defaults_config['location']['action'];
}

if (!file_exists(BASE_DIR.'/controllers/'.strtolower($_GET['controller']).'.php'))
{
	include_once '/sys/404.php';

	return ;
}

$controller_class = 'Controllers_'.ucfirst($_GET['controller']);

if (!class_exists($controller_class))
{
	include_once '/sys/404.php';

	return ;
}

$controller_object = new $controller_class();

if (!method_exists($controller_object, $_GET['action']))
{
	include_once '/sys/404.php';

	return ;
}

$controller_object->{$_GET['action']}();


