<?php
class Models_Users
{
	private $_table;
	private $_profile_table;
	private $_users_buildings_table;

	public function  __construct()
	{
		$this->_table = new Db_Users();
		$this->_table->setAlias('u');
		$this->_profile_table = new Db_Profiles();
		$this->_profile_table->setAlias('p');
		$this->_users_buildings_table = new Db_UsersBuildings();
		$this->_users_buildings_table->setAlias('ub');
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

	public function assignBuilding($user_id, $building_id, $is_current = false)
	{
		$data = array(
			'user_id' => $user_id,
			'building_id' => $building_id,
			'is_current' => $is_current ? 1 : 0
		);
		return $this->_users_buildings_table->insert($data);
	}

	public function appendBasicData(array $data)
	{
		$user_id = $data['id'];

		$buildings_table = new Db_Buildings();
		$buildings_table->setAlias('b');
		$streets_table = new Db_Streets();
		$streets_table->setAlias('s');

		$current_building = $this->_users_buildings_table
			->select('b.id, b.number, b.street_id, s.name')
			->where('ub.user_id', $user_id)
			->where('ub.is_current', 1)
			->join($buildings_table, 'b.id = ub.building_id')
			->join($streets_table, 'b.street_id = s.id')
			->fetchOne();

		$data['current_building'] = $current_building;

		return $data;
	}
}
