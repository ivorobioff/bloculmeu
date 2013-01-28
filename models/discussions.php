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

		$res = $this->_table
			->select('d.*, p.fio')
			->join($profile_table, 'd.user_id=p.user_id')
			->where('building_id', Db_Currents::getBuildingInfo('id'))
			->orderBy('d.id')
			->fetchAll();

		return new Libs_DiscussionsList($res);
	}
}