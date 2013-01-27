<?php
class Controllers_Buildings extends Controllers_Common
{
	protected $_auth_exceptions = array('getNumbers');

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
}