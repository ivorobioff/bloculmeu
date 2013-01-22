<?php
namespace Lib\Modules;

use Plugins\Utils\SmartArray;
use Plugins\Utils\Massive;


class InstalledResults extends SmartArray
{
	private $_saved_modules = array();

	public function offsetGet($offset)
	{
		return new InstalledRows($this->_data[$offset]);
	}
}