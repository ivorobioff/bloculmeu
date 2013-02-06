<?php
class Controllers_Messages extends Controllers_Common
{
	public function index($parmas = array())
	{
		$active_user_id = intval(always_set($parmas, 0, 0));

		if (!$this->_isValidActiveUser($active_user_id))
		{
			$active_user_id = 0;
		}

		$model = new Models_Dialogs();
	
		$this->_view->assign('dialogs_list', $model->get4Main($active_user_id));
		$this->_view->assign('active_user_id', $active_user_id);

		$this->_view->render('messages/index.phtml');
	}

	private function _isValidActiveUser($active_user_id)
	{
		if ($active_user_id == Db_Currents::getUserInfo('id'))
		{
			return false;
		}

		$table = new Models_Neighbors();

		if (!$table->isNeighbor($active_user_id, true))
		{
			return false;
		}

		return true;
	}
}
