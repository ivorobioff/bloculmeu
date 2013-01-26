<?php
class Views_Helpers_MenuHeader
{
	static public function draw(array $config)
	{
		foreach ($config as $item)
		{
			if (is_location($item['url']))
			{
				echo '<span>'.$item['title'].'</span>';
			}
			else
			{
				echo '<a href="'.$item['url'].'">'.$item['title'].'</a>';
			}
		}
	}
}