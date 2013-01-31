<?php
class Models_Dialogs
{
	public function get4Main($active_user_id = 0)
	{
		$table = new Db_Messages();
		$table
			->where('(sender_id='.Db_Currents::getUserInfo('id').' OR receiver_id='.Db_Currents::getUserInfo('id').')');
		
		if ($active_user_id)
		{
			$table->where('sender_id != '.$active_user_id.' AND receiver_id != '.$active_user_id);
		}
		
		
	}
}
