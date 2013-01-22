<?php
namespace System\Lib;

class Session
{
	static public function get($key, $default = null)
	{
		return always_set($_SESSION, $key, $default);
	}

	static public function set($key, $value)
	{
		$_SESSION[$key] = $value;
	}

	static public function delete($key)
	{
		unset($_SESSION[$key]);
	}

	static public function exists($key)
	{
		return isset($_SESSION[$key]);
	}
}