<?php
class Models_Neighbors
{
	public function get4Main()
	{
		$users_buildings_table = new Db_UsersBuildings();
		$users_buildings_table->setAlias('ub');
		$profiles_table = new Db_Profiles();
		$profiles_table->setAlias('p');

		$res = $users_buildings_table
			->select('p.*')
			->join($profiles_table, 'p.user_id=ub.user_id')
			->where('ub.building_id', Db_Currents::getBuildingInfo('id'))
			->where('ub.user_id !=', Db_Currents::getUserInfo('id'))
			->fetchAll();

		return $res;
	}

	public function getOther()
	{
		$users_buildings_table = new Db_UsersBuildings();
		$users_buildings_table->setAlias('ub');

		$courtyard_table = new Db_Courtyards();
		$courtyard_table->setAlias('c');

		$profiles_table = new Db_Profiles();
		$profiles_table->setAlias('p');

		return $courtyard_table
			->select('p.*')
			->join($users_buildings_table, 'ub.building_id=c.building_id')
			->join($profiles_table, 'p.user_id=ub.user_id')
			->where('c.user_id', Db_Currents::getUserInfo('id'))
			->groupBy('ub.user_id')
			->fetchAll();
	}
}