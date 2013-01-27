<?php
/**
 * Информация о  текущем пользователе
 * @author Igor Vorobioff<i_am_vib@yahoo.com>
 */
class Db_Currents
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