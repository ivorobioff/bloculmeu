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
			->join($users_buildings_table, 'ub.building_id=c.building_id', 'INNER JOIN')
			->join($profiles_table, 'p.user_id=ub.user_id')
			->where('c.user_id', Db_Currents::getUserInfo('id'))
			->where('c.current_building_id', Db_Currents::getBuildingInfo('id'))
			->groupBy('ub.user_id')
			->fetchAll();
	}

	/**
	 * Проверяем если пользователь является соседом
	 * @param int $user_id
	 */
	public function isNeighbor($user_id, $for_all = false)
	{
		$table = new Db_UsersBuildings();

		$my_buildings = Db_Currents::getUserInfo('id');

		if ($for_all)
		{
			$my_buildings = $table
				->where('user_id', Db_Currents::getUserInfo('id'))
				->getVector('building_id',0 , array(0));
		}


		$res = $table
			->where('building_id', $my_buildings)
			->where('user_id', $user_id)
			->check();

		if ($res)
		{
			return true ;
		}

		$court_table = new Db_Courtyards();

		$buildings = $court_table
			->where('user_id', Db_Currents::getUserInfo('id'))
			->where('current_building_id', $my_buildings)
			->getVector('building_id',0 ,array(0));

		$res = $table
			->where('user_id', $user_id)
			->where('building_id', $buildings)
			->check();

		if ($res)
		{
			return true ;
		}

		return false;
	}
}