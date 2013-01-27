<?php
class Models_Discussions
{
	private $_table;

	public function __construct()
	{
		$this->_table = new Db_Discussions();
		$this->_table->setAlias('d');
	}

	public function add($data)
	{
		return $this->_table->insert($data);
	}

	public function get4Main()
	{
		$profile_table = new Db_Profiles();
		$profile_table->setAlias('p');

		$res = $this->_table
			->select('d.*, p.fio')
			->join($profile_table, 'd.user_id=p.user_id')
			->where('building_id', Db_Currents::getBuildingInfo('id'))
			->orderBy('d.id')
			->fetchAll();

		return new Libs_DiscussionsList($res);
	}
}