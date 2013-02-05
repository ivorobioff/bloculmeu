<?php
class Models_Lists_Messages extends Libs_IteratorReplacer
{
	private $_profiles_table = null;
	
	public function __construct($data)
	{
		parent::__construct($data);
		$this->_profiles_table = new Db_Profiles();
	}
	
	public function current()
	{
		$res = current($this->_data);
		
		if ($res['sender_id'] == Db_Currents::getUserInfo('id'))
		{
			$res['fio'] = _t('/messages/sender-you/');
		}
		else
		{
			$res['fio'] = $this->_profiles_table
				->where('user_id', $res['sender_id'])
				->getValue('fio', '');
		}
				
		return $res;
	}
}
