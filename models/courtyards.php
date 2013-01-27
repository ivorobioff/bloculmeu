<?php
class Models_Courtyards
{
	private $_table;

	public function __construct()
	{
		$this->_table = new Db_Courtyards();
	}

	public function add($building_id)
	{
		$data = array(
			'user_id' => Db_Currents::getUserInfo('id'),
			'building_id' => $building_id
		);
		return $this->_table->insert($data);
	}

	public function checkBuilding($building_id)
	{
		return $this->_table
			->where('user_id', Db_Currents::getUserInfo('id'))
			->where('building_id', $building_id)
			->check();
	}
}