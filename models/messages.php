<?php
class Models_Messages
{
	private $_table;

	public function __construct()
	{
		$this->_table = new Db_Messages();
		$this->_table->setAlias('m');
	}

	public function get4User($user_id, $offset = 0, $limit = 10)
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
			->where($main_where)
			->orderBy('m.id', 'DESC')
			->limit($offset, $limit)
			->fetchAll();

		return new Models_Lists_Messages($data);
	}

	public function getMessageById($id)
	{
		$item = $this->_table->fetchOne('id', $id);
		$item = new Models_Items_Message($item);

		return $item->get();
	}

	public function post($id, $message)
	{
		$data = array(
			'`text`' => $message,
			'sender_id' => Db_Currents::getUserInfo('id'),
			'receiver_id' => $id
		);

		return $this->_table->insert($data);
	}
}
