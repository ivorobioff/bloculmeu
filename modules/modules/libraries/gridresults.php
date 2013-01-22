<?php
namespace Lib\Modules;

use Plugins\Utils\SmartArray;
use Plugins\Utils\Massive;


class GridResults extends SmartArray
{
	private $_saved_modules = array();

	public function offsetGet($offset)
	{
		return new GridRows($this->_data[$offset]);
	}
}