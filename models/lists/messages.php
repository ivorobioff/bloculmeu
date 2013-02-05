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
		
		if (isset($res['another_user']))
		{
			
		}
		else
		{
			
		}
		
		$res['fio'] = $this->_profiles_table
			->where('user_id', $res['another_user'])
		
		return $res;
	}
}
