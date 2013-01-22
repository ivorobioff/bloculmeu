<?php
namespace Model\Users\Admin;

use Model\Users\Common;
use \Db\Users\Admin\Users as TableUsers;

class Users extends Common
{
	public function _getTable()
	{
		return new TableUsers();
	}

	public function create(array $data)
	{

	}
}