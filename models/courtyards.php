<?php
class Models_Courtyards
{
	private $_table;

	public function __construct()
	{
		$this->_table = new Db_Courtyards();
		$this->_table->setAlias('c');
	}

	public function add($building_id)
	{
		$data = array(
			'user_id' => Db_Currents::getUserInfo('id'),
			'current_building_id' => Db_Currents::getBuildingInfo('id'),
			'building_id' => $building_id
		);
		return $this->_table->insert($data);
	}

	public function checkBuilding($building_id)
	{
		return $this->_table
			->where('user_id', Db_Currents::getUserInfo('id'))
			->where('current_building_id', Db_Currents::getBuildingInfo('id'))
			->where('building_id', $building_id)
			->check();
	}

	public function get4Main()
	{
		return $this->_get4();
	}

	public function getItem4Main($id)
	{
		return $this->_get4($id);
	}

	private function _get4($id = 0)
	{
		$building_table = new Db_Buildings();
		$building_table->setAlias('b');
		$streets_table = new Db_Streets();
		$streets_table->setAlias('s');

		$this->_table
			->select('b.id, s.name, b.number')
			->join($building_table, 'b.id=c.building_id')
			->join($streets_table, 's.id = b.street_id')
			->where('c.user_id', Db_Currents::getUserInfo('id'))
			->where('c.current_building_id', Db_Currents::getBuildingInfo('id'))
			->orderBy('c.id');

		if ($id)
		{
			return $this->_table->fetchOne('c.building_id', $id);
		}

		return $this->_table->fetchAll();
	}
}