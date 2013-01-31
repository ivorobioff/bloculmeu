<?php
class Controllers_Messages extends Controllers_Common
{
	public function index($parmas = array())
	{
		$model = new Models_Dialogs();

		if ($user_id = intval(always_set($parmas, 0, 0)))
		{
			$this->_view->assign('active_dialog', $model->getFakeOne($user_id));
		}

		$this->_view->render('messages/index.phtml');
	}
}