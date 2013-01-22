<?php
namespace Model\Users;

use \System\Mvc\Model as SystemModel;

abstract class Common extends SystemModel
{
	public function getAuthUser($email, $password)
	{
		return $this->_table
			->where('email', $email)
			->where('password', $password)
			->fetchOne();
	}
}