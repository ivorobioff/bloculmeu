<?php
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

function _t($alias)
{
	include BASE_DIR.'/config/labels.php';

	return always_set($labels, $alias, $alias);
}

function _url($url)
{
	return $url;
}

function always_set($array, $key, $default = null)
{
	return isset($array[$key]) ? $array[$key] : $default;
}

function is_location($url)
{
	$url = trim($url, '/');
	$url = explode('/', $url);

	return $url[0] == $_GET['controller'] && $url[1] == $_GET['action'];
}

function is_ajax()
{
	return isset($_SERVER['HTTP_X_REQUESTED_WITH'])
		&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

function is_auth()
{
	return isset($_SESSION['user']);
}

function redirect($url)
{
	header('location: '.$url);
	exit();
}