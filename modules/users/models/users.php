<?php
namespace Model\Users;

use Model\Users\Common;
use \Db\Users\Users as TableUsers;

class Users extends Common
{
	public function _getTable()
	{
		return new TableUsers();
	}
}