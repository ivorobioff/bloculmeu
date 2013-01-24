<?php
class Models_Users
{
	private $_table;

	public function  __construct()
	{
		$this->_table = new Db_Users();
	}

	public function add($data)
	{
		return $this->_table->insert($data);
	}

	public function getOne($email, $password)
	{
		$password = md5($password);

		return  $this->_table
			->where('password', $password)
			->where('email', $email)
			->fetchOne();
	}
}