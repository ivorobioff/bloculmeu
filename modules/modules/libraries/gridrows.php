<?php
namespace Lib\Modules;

use Plugins\Utils\SmartArray;

class GridRows extends SmartArray
{
	public function __construct($data)
	{
		$item =  array(
			'title' => $data['info']['title'],
			'description' => $data['info']['description'],
			'pin' => $data['pin'],
			'name' => $data['name']
		);

		if ($guid = always_set($data, 'guid'))
		{
			$item['guid'] = $guid;
		}

		parent::__construct($item);
	}
}