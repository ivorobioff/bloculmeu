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


	public function send()
	{
		try
		{
			Libs_Validator::setness($_POST, array('id', 'message'));

			$_POST['id'] = intval($_POST['id']);

			Libs_Validator::emptyness($_POST, array('message', 'id'));
		}
		catch (Libs_Exceptions_NotPassedValidation $ex)
		{
			return send_form_error(array('code' => __LINE__));
		}

		$model = new Models_Messages();

		if (!$id = $model->post($_POST['id'], $_POST['message']))
		{
			return send_form_error(array('code' => __LINE__));
		}

		if (!$item = $model->getMessageById($id))
		{
			return send_form_error(array('code' => __LINE__));
		}

		send_form_success(array('html' => $this->_view->block('messages/item.phtml', $item, false)));
	}

	public function getAll($params)
	{
		if (!is_ajax())
		{
			return send_form_error();
		}

		if (!$id = always_set($params, 0, 0))
		{
			return send_form_error(array('code' => __LINE__));
		}

		$model = new Models_Messages();

		send_form_success(array('html' => $this->_view->block('messages/items.phtml', $model->get4User($id), false)));
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
