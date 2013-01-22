<?php
namespace Plugins\Utils;

use \Plugins\Utils\SmartArray;
use \Plugins\Utils\MasterString;
/**
 * Класс все еще на стадии разработки. Не используется в проекте
 * @author Igor Vorobioff<i_am_vib@yahoo.com>
 */
class MasterArray extends SmartArray
{
	public function keys()
	{
		return new self(array_keys($this->toArray()));
	}

	public function exists($key)
	{
		return array_key_exists($key, $this);
	}

	public function get($key)
	{
		return $this[$key];
	}

	public function offsetGet($offset)
	{
		$res = $this->_data[$offset];

		if (is_string($res))
		{
			return new MasterString($res);
		}

		if (is_array($res))
		{
			return new self($res);
		}

		return $res;
	}

	public function toString($ch = ',')
	{
		return implode($ch, $this->toArray());
	}

	public function __toString()
	{
		return $this->toString();
	}
}