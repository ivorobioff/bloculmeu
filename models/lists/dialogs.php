<?php
class Models_Lists_Dialogs extends Libs_IteratorReplacer
{
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