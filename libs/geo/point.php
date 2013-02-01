<?php
class Libs_Geo_Point
{
	private $_latitude;
	private $_longitude;

	public function __construct($latitude, $longitude)
	{
		$this->_latitude = $latitude;
		$this->_longitude = $longitude;
	}

	public function getLatitude()
	{
		return $this->_latitude;
	}

	public function getLongitude()
	{
		return $this->_longitude;
	}
}