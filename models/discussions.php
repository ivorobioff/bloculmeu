<?php
class Models_Discussions
{
	private $_table;

	public function __construct()
	{
		$this->_table = new Db_Discussions();
		$this->_table->setAlias('d');
	}

	public function add($data)
	{
		$type = $data['type'];

		unset($data['type']);

		$id = $this->_table->insert($data);

		if ($type)
		{
			$this->_relateCourtyardTo($id);
		}

		return $id;
	}

	private function _relateCourtyardTo($id)
	{
		$courtyard_table = new Db_Courtyards();
		$courtyards_ids = $courtyard_table
			->select('building_id')
			->where('user_id', Db_Currents::getUserInfo('id'))
			->where('current_building_id', Db_Currents::getBuildingInfo('id'))
			->getVector('building_id');

		if (!$courtyards_ids)
		{
			return ;
		}

		$many_data = array();

		foreach ($courtyards_ids as $value)
		{
			$many_data[] = array(
				'building_id' => $value,
				'discussion_id' => $id
			);
		}

		$discussions_buildings_table = new Db_DiscussionsBuildings();
		$discussions_buildings_table->insertAll($many_data);

	}

	public function get4Main()
	{
		$profile_table = new Db_Profiles();
		$profile_table->setAlias('p');

		$discussions_users_table = new Db_DiscussionsUsers();
		$query = $discussions_users_table
			->setAlias('du')
			->setQueryReturnMode()
			->select('du.discussion_id')
			->where('du.user_id', Db_Currents::getUserInfo('id'))
			->where('du.status', 'accept')
			->fetchAll();
		$cb = Db_Currents::getBuildingInfo('id');

		$discussions_buildings_table = new Db_DiscussionsBuildings();
		$select_1 = $discussions_buildings_table
			->setAlias('db')
			->setQueryReturnMode()
			->select('d.*')
			->join($this->_table, 'd.id=db.discussion_id')
			->where('db.building_id', $cb)
			->where('db.discussion_id IN ('.$query.')')
			->fetchAll();

		$select_2 = $this->_table
			->setQueryReturnMode()
			->select('d.*')
			->where('d.building_id', $cb)
			->fetchAll();

		$sql = 'SELECT t1.*, p.fio FROM
		(
			'.$select_1.' UNION '.$select_2.'
		) AS t1
		LEFT JOIN '.$profile_table->getTableName().' AS '.$profile_table->getAlias().'
		ON t1.user_id=p.user_id
		ORDER BY t1.id DESC
		';

		$res = $this->_table->getResult($sql);


		return new Models_Lists_Discussions($res);
	}
}