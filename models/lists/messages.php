<?php
class Models_Lists_Messages extends Libs_IteratorReplacer
{
	public function __construct($data)
	{
		parent::__construct($data);
		$this->_data = array_reverse($this->_data);
	}

	public function current()
	{
		$item = current($this->_data);
		$item = new Models_Items_Message($item);

		return $item->get();
	}
}
