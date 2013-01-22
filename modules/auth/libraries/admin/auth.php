<?php
namespace Lib\Auth\Admin;

use \Lib\Auth\Common;
use	\Model\Users\Admin\Users as ModelUsers;

class Auth extends Common
{
	protected $_session_key = 'admin_user';

	static private $_instance = null;

	public function __construct()
	{
		$this->_model = new ModelUsers();
	}

	static public function getInstance()
	{
		if (is_null(self::$_instance))
		{
			self::$_instance = new self();
		}

		return  self::$_instance;
	}
}