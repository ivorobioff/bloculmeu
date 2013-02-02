<?php
class Models_Lists_Invitations extends Libs_IteratorReplacer
{
	public function current ()
	{
		$res = current($this->_data);

		$streets_table = new Db_Streets();
		$streets_table->setAlias('s');

		$buildings_table = new Db_Buildings();

		$res['address'] = $buildings_table
			->setAlias('b')
			->select('CONCAT(s.name, " ", b.number) AS address')
			->join($streets_table, 'b.street_id=s.id')
			->where('b.id', $res['building_id'])
			->getValue('address');

		return $res;
	}
}