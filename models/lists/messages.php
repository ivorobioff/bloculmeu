<?php
class Models_Lists_Messages extends Libs_IteratorReplacer
{
	public function current()
	{
		$item = current($this->_data);
		$item = new Models_Items_Message($item);

		return $item->get();
	}
}
