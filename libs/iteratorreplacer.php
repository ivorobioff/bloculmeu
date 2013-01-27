<?php
abstract class Libs_IteratorReplacer implements Iterator
{
	protected $_data = array();

	public function __construct(array $data)
	{
		$this->_data = $data;
	}

	abstract public function current ();

	public function next ()
	{
		next($this->_data);
	}

	public function key ()
	{
		return key($this->_data);
	}

	public function valid ()
	{
		return isset($this->_data[$this->key()]);
	}

	public function rewind ()
	{
		reset($this->_data);
	}
}