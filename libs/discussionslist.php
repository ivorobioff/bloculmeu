<?php
class Libs_DiscussionsList extends Libs_IteratorReplacer
{
	public function current ()
	{
		$res = current($this->_data);

		$res['is_owner'] = false;

		if ($res['user_id'] == Db_Currents::getUserInfo('id'))
		{
			$res['is_owner'] = true;
		}

		return $res;
	}
}