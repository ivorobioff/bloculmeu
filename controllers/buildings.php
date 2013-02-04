<?php
class Controllers_Buildings extends Controllers_Common
{
	protected $_require_auth = false;

	public function getNumbers($params)
	{
		if (!$id = intval(always_set($params, 0)))
		{
			echo '';
			return ;
		}

		$model = new Models_Buildings();
		$data = $model->getNumbers($id);

		$options = '';

		foreach ($data as $key => $value)
		{
			$options .= '<option value='.htmlspecialchars($value).'>'.htmlspecialchars($value).'</option>';
		}

		echo $options;
	}

	public function geo($params)
	{
		$latitude = always_set($params, 0, false);
		$longitude = always_set($params, 1, false);

		if ($latitude === false || $longitude === false){
			return send_form_error();
		}

		$model = new Models_Buildings();
		$data = $model->getSomeByGeo($latitude, $longitude);

		send_form_success(array('html' => $this->_view->block('auth/buildings_geo.phtml', $data, false)));
	}
}