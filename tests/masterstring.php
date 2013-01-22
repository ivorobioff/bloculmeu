<?php
namespace Ctest;

use \Plugins\Utils\MasterString as UtilsMasterString;

class MasterString extends \PHPUnit_Framework_TestCase
{
	public function testObjectInsideObject()
	{
		$str1 = new UtilsMasterString('hello');
		$str2 = new UtilsMasterString($str1);

		$this->assertTrue($str2->ucfirst() == 'Hello');
	}
}