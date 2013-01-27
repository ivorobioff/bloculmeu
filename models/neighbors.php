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
}