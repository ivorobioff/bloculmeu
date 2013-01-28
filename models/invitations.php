<?php
class Models_Invitations
{
	public function accept()
	{

	}

	public function decline()
	{

	}

	public function get4Main()
	{
		$discussions_buildings_table = new Db_DiscussionsBuildings();
		$discussions_buildings_table->setAlias('db');

		$discussions_users_table = new Db_DiscussionsUsers();
		$discussions_users_table->setAlias('du');
		$discussions_users_query = $discussions_users_table
			->setQueryReturnMode()
			->select('du.discussion_id')
			->where('du.user_id', Db_Currents::getUserInfo('id'))
			->fetchAll();

		$discussions_table = new Db_Discussions();
		$discussions_table->setAlias('d');

		$res = $discussions_buildings_table
			->join($discussions_table, 'd.id=db.discussion_id')
			->where('db.building_id', Db_Currents::getBuildingInfo('id'))
			->where('db.discussion_id NOT IN ('.$discussions_users_query.')')
			->fetchAll();

		return $res;
	}
}