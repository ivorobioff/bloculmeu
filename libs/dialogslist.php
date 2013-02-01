<?php
class Libs_DialogsList extends Libs_IteratorReplacer
{
	public function __construct($data, $active_user_id)
	{
		parent::__construct($data);

		if ($active_user_id)
		{
			$active_dialog = array(
				'another_user' => $active_user_id,
				'me' => Db_Currents::getUserInfo('id')
			);

			array_unshift($this->_data, $active_dialog);
		}
	}

	public function current()
	{
		$res = current($this->_data);

		$profile_table = new Db_Profiles();

		$res['fio'] = $profile_table
			->where('user_id', $res['another_user'])
			->getValue('fio');

		return $res;
	}
}