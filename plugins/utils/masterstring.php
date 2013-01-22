<?php
namespace Plugins\Utils;
/**
 * Класс все еще на стадии разработки. Не используется в проекте
 * @author Igor Vorobioff<i_am_vib@yahoo.com>
 */
class MasterString
{
	private $_string = '';

	public function __construct($string)
	{
		$this->_string = (string) $string;
	}

	public function ucfirst()
	{
		$this->_string = ucfirst($this->_string);

		return $this;
	}

	public function __toString()
	{
		return $this->_string;
	}
}