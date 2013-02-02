<?php
class Models_Lists_Suggestions extends Libs_IteratorReplacer
{
	public function current()
	{
		$res = current($this->_data);

		$res['address'] = $res['name'].' '.$res['number'];

		return $res;
	}
}