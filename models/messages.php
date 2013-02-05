<?php
class Models_Messages
{
	private $_table;

	public function __construct()
	{
		$this->_table = new Db_Messages();
		$this->_table->setAlias('m');
	}

	public function get4User($user_id)
	{
		$profile_table = new Db_Profiles();
		$profile_table->setAlias('p');

		$main_where = '(m.sender_id='.$user_id.' AND m.receiver_id='.Db_Currents::getUserInfo('id')
				.') OR (m.receiver_id='.$user_id.' AND m.sender_id='.Db_Currents::getUserInfo('id').')';

		return $this->_table
			
			->where($main_where)
			->fetchAll();
	}
}
