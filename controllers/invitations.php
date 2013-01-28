<?php
class Controllers_Invitations extends Controllers_Common
{
	public function index()
	{
		$model = new Models_Invitations();

		$this->_view->assign('invitations_list', $model->get4Main());
		$this->_view->render('invitations/index.phtml');
	}

	public function accept()
	{
		try
		{
			$this->_response('accept', $_POST);
		}
		catch (Exception $ex)
		{
			echo 'error';

			return ;
		}

		echo 'ok';
	}

	public function decline()
	{
		try
		{
			$this->_response('decline', $_POST);
		}
		catch (Exception $ex)
		{
			echo 'error';

			return ;
		}

		echo 'ok';
	}

	private function _response($type, $data)
	{
		if (!isset($data['id']))
		{
			throw new Exception('unknown error');
		}

		$model = new Models_Invitations();

		if(!$discussion_id = $model->getDiscussionId($data['id']))
		{
			throw new Exception('unknown error');
		}

		if (!$id = $model->saveResponse($discussion_id, $type))
		{
			throw new Exception('unknown error');
		}

		return $id;
	}
}