<?php
class Models_Invitations
{
	private $_table;

	public function __construct()
	{
		$this->_table = new Db_DiscussionsBuildings();
		$this->_table->setAlias('db');
	}

	public function saveResponse($id, $type)
	{
		$data = array(
			'user_id' => Db_Currents::getUserInfo('id'),
			'discussion_id' => $id,
			'status' => $type
		);

		$table = new Db_DiscussionsUsers();

		return $table->insert($data);
	}

	public function getDiscussionId($id)
	{
		return $this->_table
			->select('discussion_id')
			->where('id', $id)
			->where('building_id', Db_Currents::getBuildingInfo('id'))
			->getValue('discussion_id', false);
	}

	public function get4Main()
	{
		$discussions_users_table = new Db_DiscussionsUsers();
		$discussions_users_table->setAlias('du');

		$discussions_users_query = $discussions_users_table
			->setQueryReturnMode()
			->select('du.discussion_id')
			->where('du.user_id', Db_Currents::getUserInfo('id'))
			->fetchAll();

		$discussions_table = new Db_Discussions();
		$discussions_table->setAlias('d');

		$res = $this->_table
			->select('d.*, db.id AS invitation_id')
			->join($discussions_table, 'd.id=db.discussion_id')
			->where('db.building_id', Db_Currents::getBuildingInfo('id'))
			->where('db.discussion_id NOT IN ('.$discussions_users_query.')')
			->fetchAll();

		return new Models_Lists_Invitations($res);
	}
}