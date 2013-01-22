<?php
header('Content-Type: text/html; charset=utf-8');

ini_set('display_errors', 'On');
error_reporting(E_ALL);

include_once '/system/lib/shortcuts.php';
include_once '/system/lib/autoloader.php';

session_start();

function __autoload($class)
{
	include_once Autoloader::getInstance()->getPath($class);
}

try
{
	\System\Lib\Router::getInstance()->run();
}
catch (\System\Error404\Exception $ex)
{
	$ex->load();
}