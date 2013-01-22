<?php
namespace System\Lib;

class Config
{
	private $_settings = array();

	static private $_instance = null;

	public function __construct()
	{
		include '/config/settings.php';
		$this->_settings = $config;
	}

	/**
	 * @return \System\Lib\Config;
	 */
	static public function getInstance()
	{
		if (is_null(self::$_instance))
		{
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function getSettings($key)
	{
		return $this->_settings[$key];
	}
}