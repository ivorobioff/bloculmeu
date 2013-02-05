<?php
class Models_Lists_Messages extends Libs_IteratorReplacer
{
	public function current()
	{
		$res = current($this->_data);
		return $res;
	}
}
