<?php
namespace Lib\Common;
use System\Lib\Router;
use \Plugins\Minimizer\Minimizer;
use \Plugins\Minimizer\Exception as MinException;

class QuickMin
{
	/**
	 * Запускает настроенный минимайзер
	 */
	static public function run()
	{
		$minimize = new Minimizer('/front/min_config.xml', Router::getInstance()->isAdmin());

		try
		{
			$minimize->process(false);
		}
		catch (MinException $ex)
		{
			die($ex->getMessage());
		}
	}
}