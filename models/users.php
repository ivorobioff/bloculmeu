<?php
class Models_Users
{
	private $_table;
	private $_profile_table;

	public function  __construct()
	{
		$this->_table = new Db_Users();
		$this->_table->setAlias('u');
		$this->_profile_table = new Db_Profiles();
		$this->_profile_table->setAlias('p');
	}

	public function add($data)
	{
		$basic_data = array(
			'email' => $data['email'],
			'password' => md5($data['password'])
		);

		if(!$id = $this->_table->insert($basic_data))
		{
			return false;
		}

		$profile_data = array(
			'user_id' => $id,
			'fio' => $data['fio']
		);

		$this->_profile_table->insert($profile_data);

		return $id;
	}

	public function get4Auth($email, $password)
	{
		$password = md5($password);

		return  $this->_table
			->join($this->_profile_table, 'u.id=p.user_id')
			->where('u.password', $password)
			->where('u.email', $email)
			->where('u.active', 1)
			->fetchOne();
	}

	public function checkEmail($email)
	{
		return $this->_table->fetchOne('email', $email) ? true : false;
	}

	public function getByHashedId($id)
	{
		return  $this->_table
			->join($this->_profile_table, 'u.id=p.user_id')
			->fetchOne('MD5(u.id)', $id);
	}
}
