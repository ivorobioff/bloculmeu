<?php
namespace Ctest;

use \Plugins\Utils\MasterArray as UtilsMasterArray;

class MasterArray extends \PHPUnit_Framework_TestCase
{
	public function testKeys()
	{
		try
		{
			$arr = new UtilsMasterArray(array('a' => 'a', 'b' => 'b'));

			$key = $arr->keys();

			$this->assertTrue($key[0] == 'a' && $key[1] == 'b');
		}
		catch (\Exception $ex)
		{
			pred($ex->getMessage());
		}
	}

	public function testToString()
	{
		try
		{
			$arr = new UtilsMasterArray(array('a' => 'a', 'b' => 'b'));

			$this->assertTrue($arr == 'a,b');
		}
		catch (\Exception $ex)
		{
			pred($ex->getMessage());
		}
	}
}