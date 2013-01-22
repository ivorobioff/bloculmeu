<?php
namespace System\Lib;

use System\Lib\Router;

/**
 * Класс для работы с http функционалом.
 * @author Igor Vorobioff<i_am_vib@yahoo.com>
 */
class Http
{
	static public function get($key = null, $default = null)
	{
		return  self::_request('get', $key, $default);
	}

	static public function post($key = null, $default = null)
	{
		return self::_request('post', $key, $default);
	}

	static public function request($key = null, $default = null)
	{
		return self::_request('request', $key, $default);
	}

	static private function _request($type, $key, $default)
	{
		if ($type == 'get')
		{
			if (is_null($key))
			{
				return $_GET;
			}

			return always_set($_GET, $key, $default);
		}

		if ($type == 'post')
		{
			if (is_null($key))
			{
				return $_POST;
			}

			return always_set($_POST, $key, $default);
		}

		if (is_null($key))
		{
			return $_REQUEST;
		}

		return always_set($_REQUEST, $key, $default);
	}


	static public function isAjax()
	{
		return isset($_SERVER['HTTP_X_REQUESTED_WITH'])
			&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
	}

	static public function redirect($url)
	{
		header('location: '.$url);
		exit(0);
	}

	static public function params($index = null, $default = false)
	{
		$url = Router::getInstance()->getArrayPath();

		unset($url[0], $url[1], $url[2]);

		$url = array_merge(array(), $url);

		if (is_null($index))
		{
			return $url;
		}

		return always_set($url, $index, $default);
	}

	/**
	 * Путь текущего местоположения.
	 * Данный путь включает 3 сегмента:
	 * <ul>
	 * 		<li>Модуль</li>
	 * 		<li>Контроллер</li>
	 * 		<li>Действие</li>
	 * </ul>
	 */
	static public function location()
	{
		$url = Router::getInstance()->getArrayPath();

		return ('/'.$url[0].'/'.$url[1].'/'.$url[2].'/');
	}
}