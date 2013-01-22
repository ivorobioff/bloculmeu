<?php
namespace Lib\Auth;

use \Lib\Auth\Common;
use	\Model\Users\Users as ModelUsers;

class Auth extends Common
{
	protected $_session_key = 'user';

	public function __construct()
	{
		$this->_model = new ModelUsers();
	}
}