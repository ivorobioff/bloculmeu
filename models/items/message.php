<?php
class Models_Items_Message
{
	private $_data;

	public function __construct($data)
	{
		$this->_data = $data;
	}

	public function get()
	{
		if (!$this->_data)
		{
			return array();
		}

		$profile_table = new Db_Profiles();

		if ($this->_data['sender_id'] == Db_Currents::getUserInfo('id'))
		{
			$this->_data['fio'] = _t('/messages/sender-you');
		}
		else
		{
			$this->_data['fio'] = $profile_table
				->where('user_id', $this->_data['sender_id'])
				->getValue('fio', '');
		}

		return $this->_data;
	}
}