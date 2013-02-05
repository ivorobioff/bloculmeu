<?php
class Models_Dialogs
{
	public function get4Main($active_user_id = 0)
	{
		$table = new Db_Messages();
		$table
			->select('IF(sender_id="'.Db_Currents::getUserInfo('id').'", receiver_id, sender_id) AS another_user')
			->select('IF(sender_id="'.Db_Currents::getUserInfo('id').'", sender_id, receiver_id) AS me')
			->select('id')
			->where('(sender_id="'.Db_Currents::getUserInfo('id').'" OR receiver_id="'.Db_Currents::getUserInfo('id').'")');

		if ($active_user_id)
		{
			$table
				->where('sender_id != ', $active_user_id)
				->where('receiver_id !=', $active_user_id);
		}

		$table
			->orderBy('insert_date')
			->groupBy('another_user');

		$data = $table->fetchAll();

		if ($active_user_id)
		{
			$active_dialog = array(
				'another_user' => $active_user_id,
				'me' => Db_Currents::getUserInfo('id'),
				'active' => true
			);

			array_unshift($data, $active_dialog);
		}

		return new Models_Lists_Dialogs($data);

	}
}
