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
		if ($user_id == 0)
		{
			return array();
		}
		
		$profile_table = new Db_Profiles();
		$profile_table->setAlias('p');

		$main_where = '(m.sender_id='.$user_id.' AND m.receiver_id='.Db_Currents::getUserInfo('id')
				.') OR (m.receiver_id='.$user_id.' AND m.sender_id='.Db_Currents::getUserInfo('id').')';

		$data = $this->_table
			->select('IF(m.sender_id="'.Db_Currents::getUserInfo('id').'", m.receiver_id, m.sender_id) AS another_user')
			->select('IF(m.sender_id="'.Db_Currents::getUserInfo('id').'", m.sender_id, m.receiver_id) AS me')
			->where($main_where)
			->fetchAll();
			
		return new Models_List_Messages($data);
	}
}
