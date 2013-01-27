<?php
class Views_Helpers_Menu
{
	static public function drawHeaderMenu(array $config)
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

	static public function drawUserMenu(array $config)
	{
		foreach ($config as $item)
		{
			echo '<div style="margin-bottom: 10px;">';

			if (is_location($item['url']))
			{
				echo '<span>'.$item['title'].'</span>';
			}
			else
			{
				echo '<a href="'.$item['url'].'">'.$item['title'].'</a>';
			}

			echo '</div>';
		}
	}
}