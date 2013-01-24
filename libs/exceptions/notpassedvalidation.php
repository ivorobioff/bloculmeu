<?php
class Libs_Exceptions_NotPassedValidation extends Exception
{
	private $_data;

	public function __construct($data)
	{
		parent::__construct();
		$this->_data = $data;
	}

	public function getData()
	{
		return $this->_data;
	}
}