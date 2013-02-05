<?php
class Models_Lists_Messages extends Libs_IteratorReplacer
{
	private $_profile_table = null;
	
	public function __construct($data)
	{
		parent::__construct($data);
		$this->_profile_table = new Db_Profiles();
		$this->_profile_table->setAlias('p');
	}
	
	public function current()
	{
		$res = current($this->_data);
		return $res;
	}
}
