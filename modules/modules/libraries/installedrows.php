<?php
namespace Lib\Modules;

use Plugins\Utils\SmartArray;
use Plugins\Utils\Massive;


class InstalledRows extends SmartArray
{
	private $_saved_modules = array();

	public function offsetGet($offset)
	{
		if ($offset == 'menu')
		{
			return unserialize($this->_data[$offset]);
		}

		return $this->_data[$offset];
	}
}