<?php
class Models_Courtyards
{
	private $_table;

	const NEIGHBORS_RADIUS = 200;

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

	public function getSuggestions()
	{
		$calc = new Libs_Geo_Calculator();

		$table = new Db_Buildings();
		$table->setAlias('b');

		$streets_table = new Db_Streets();
		$streets_table->setAlias('s');

		$courtyard_buildings = $this->_table
			->setQueryReturnMode()
			->select('building_id')
			->where('user_id', Db_Currents::getUserInfo('id'))
			->where('current_building_id', Db_Currents::getBuildingInfo('id'))
			->fetchAll();

		$lat = Db_Currents::getBuildingInfo('latitude');
		$long = Db_Currents::getBuildingInfo('longitude');

		$dist_query = $calc->getSqlFormula($lat, $long, 'b.latitude', 'b.longitude');

		$data = $table
			->select($dist_query.' AS distance, s.*, b.*, b.id AS building_id')
			->join($streets_table, 's.id=b.street_id')
			->where('b.id NOT IN ('.$courtyard_buildings.')')
			->where($dist_query.' <=', self::NEIGHBORS_RADIUS)
			->where('b.latitude!=', $lat)
			->where('b.longitude!=', $long)
			->orderBy('1', 'ASC')
			->fetchAll();

		return new Models_Lists_Suggestions($data);
	}
}