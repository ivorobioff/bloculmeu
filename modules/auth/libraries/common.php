<?php
namespace Lib\Auth;

use \System\Lib\Session;

abstract class Common
{
	protected $_session_key;

	protected $_model;

	public function isAuth()
	{
		return Session::exists($this->_session_key);
	}

	public function login($email, $password)
	{
		$password = md5($password);

		if($user = $this->_model->getAuthUser($email, $password))
		{
			Session::set('admin_user', $user);
			return true;
		}

		return false;
	}

	public function logout()
	{
		Session::delete($this->_session_key);
	}

	public function getUser()
	{
		return Session::get($this->_session_key);
	}
}