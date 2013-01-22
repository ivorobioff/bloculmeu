<?php
namespace Facade\Auth;

use \Lib\Auth\Admin\Auth as AdminAuth;
use \Lib\Auth\Auth;

/**
 * Общий доступ для системы авторизации
 * @author Igor Vorobioff<i_am_vib@yahoo.com>
 */

class Index
{
	static private $_instance = null;

	private $_auth = null;

	static public function getInstance()
	{
		if (is_null(self::$_instance))
		{
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function __construct()
	{
		if (is_admin())
		{
			$this->_auth = AdminAuth::getInstance();
		}
		else
		{
			$this->_auth = Auth::getInstance();
		}
	}

	public function isAuth()
	{
		return $this->_auth->isAuth();
	}

	public function login($email, $password)
	{
		return $this->_auth->login($email, $password);
	}

	public function logout()
	{
		$this->_auth->logout();
	}

	public function getUser()
	{
		return $this->_auth->getUser();
	}
}