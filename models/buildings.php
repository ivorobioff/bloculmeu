<?php
class Models_Buildings
{
	protected $_table;
	protected $_street_table;

	public function __construct()
	{
		$this->_table = new Db_Buildings();
		$this->_street_table = new Db_Streets();
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
}