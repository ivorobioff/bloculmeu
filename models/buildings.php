<?php
class Models_Buildings
{
	protected $_table;
	protected $_street_table;

	public function __construct()
	{
		$this->_table = new Db_Buildings();
		$this->_table->setAlias('b');
		$this->_street_table = new Db_Streets();
		$this->_street_table->setAlias('s');
	}

	public function getStreets()
	{
		return $this->_street_table->getHash('id', 'name');
	}

	public function getNumbers($street_id)
	{
		return $this->_table
			->select('`number`')
			->where('street_id', $street_id)
			->getVector('number', 1);
	}

	public function getByAddress($street_id, $numder)
	{
		return $this->_table
			->where('street_id', $street_id)
			->where('`number`', $numder)
			->fetchOne();
	}

	/**
	 * Достает несколько билдингов лежащие не далеко от полученой точки.
	 * @param int $latitude
	 * @param int $longitude
	 */
	public function getSomeByGeo($latitude, $longitude)
	{
		$streets_table = new Db_Streets();
		$streets_table->setAlias('s');

		$geo = new Libs_Geo_Calculator();

		return $this->_table
			->select($geo->getSqlFormula($latitude, $longitude, 'b.latitude', 'b.longitude').' AS distance')
			->select('b.*, s.name')
			->join($streets_table, 's.id=b.street_id')
			->where($geo->getSqlFormula($latitude, $longitude, 'b.latitude', 'b.longitude').'<=', 400)
			->orderBy('1', 'ASC')
			->limit(3)
			->fetchAll();
	}
}