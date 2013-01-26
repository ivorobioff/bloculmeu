<?php
class Models_Currents
{
	static public function getUserInfo($key)
	{
		return $_SESSION['user'][$key];
	}

	static public function getBuildingInfo($key)
	{
		return $_SESSION['user']['current_building'][$key];
	}
}