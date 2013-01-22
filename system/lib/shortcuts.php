<?php
use System\Lib\Router;
use System\Lib\Config;
use Facade\Auth\Index as FacadeAuth;

function root_path()
{
	return $_SERVER['DOCUMENT_ROOT'];
}

function pre($str, $die = false)
{
	echo '<pre>';
	print_r($str);
	echo '</pre>';
}

function pred($str, $die = false)
{
	pre($str);
	die();
}

function always_set($array, $key, $default = null)
{
	return isset($array[$key]) ? $array[$key] : $default;
}

/**
 * Проверяет если заданный путь является текущем местоположением.
 */
function is_location($path)
{
	return trim(\System\Lib\Http::location(), '/') == trim($path, '/');
}

function _t($alias)
{
	/*
	 * TODO: должно быть переделано
	 */
	include '/config/labels.php';

	return always_set($labels, $alias, $alias);
}

function _url($url)
{
	return $url;
}

function get_admin_name()
{
	return Config::getInstance()->getSettings('ADMIN_NAME');
}

function is_admin()
{
	return Router::getInstance()->isAdmin();
}

function is_auth()
{
	return FacadeAuth::getInstance()->isAuth();
}

function gen_guid()
{
	return uniqid();
}
