<?php
class Libs_Geo_Calculator
{
	const EARTH_RADIOS = 6371000;

	public function getSqlFormula($lat1, $long1, $lat2, $long2)
	{
		$lat1 = $lat1;
		$lat2 = $lat2;

		$long1 = $long1;
		$long2 = $long2;

		$d_lat = $this->_toSqlRad($lat2.'-'.$lat1);
		$d_long = $this->_toSqlRad($long2.'-'.$long1);

		$lat1 = $this->_toSqlRad($lat1);
		$lat2 = $this->_toSqlRad($lat2);

		$a = 'SIN('.$d_lat.'/2) * SIN('.$d_lat.'/2) + SIN('.$d_long.'/2) * SIN('.$d_long.'/2) * COS('.$lat1.') * COS('.$lat2.')';

		return self::EARTH_RADIOS.' * 2 * ATAN2(SQRT('.$a.'), SQRT(1-'.$a.'))';
	}

	public function getDistance(Libs_Geo_Point $point1, Libs_Geo_Point $point2)
	{
		$lat1 = $point1->getLatitude();
		$long1 = $point1->getLongitude();

		$lat2 = $point2->getLatitude();
		$long2 = $point2->getLongitude();

		$d_lat = $this->_toRad($lat2 - $lat1);
		$d_long = $this->_toRad($long2 - $long1);

		$lat1 = $this->_toRad($lat1);
		$lat2 = $this->_toRad($lat2);

		$a = sin($d_lat/2) * sin($d_lat/2) + sin($d_long/2) * sin($d_long/2) * cos($lat1) * cos($lat2);
		$c = 2 * atan2(sqrt($a), sqrt(1-$a));

		return self::EARTH_RADIOS * $c;
	}

	private function _toRad($num)
	{
		return $num * pi() / 180;
	}

	private function _toSqlRad($q)
	{
		return '(('.$q.') * PI() / 180)';
	}
}