<?php
class Models_Discussions
{
	private $_table;

	public function __construct()
	{
		$this->_table = new Db_Discussions();
	}

	public function add($data)
	{
		return $this->_table->insert($data);
	}

	public function get4Main()
	{

	}
}