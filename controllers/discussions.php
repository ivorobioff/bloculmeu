<?php
class Controllers_Discussions extends Controllers_Common
{
	public function index()
	{
		$model = new Models_Discussions();

		$this->_view->assign('discussions_list', $model->get4Main());

		$this->_view->assign('discussion_categories', Libs_Handbooks_Discussions::getCategories());
		$this->_view->render('discussions/index.phtml');
	}

	public function invitations()
	{
		$model = new Models_Invitations();

		$this->_view->assign('invitations_list', $model->get4Main());
		$this->_view->render('discussions/invitations.phtml');
	}

	public function add($params = array())
	{
		if (!in_array(always_set($params, 0, ''), array_keys(Libs_Handbooks_Discussions::getCategories())))
		{
			redirect(_url('/discussions/index/'));
		}

		$this->_view->assign('current_category', $params[0]);
		$this->_view->assign('categories', Libs_Handbooks_Discussions::getCategories());
		$this->_view->assign('types', Libs_Handbooks_Discussions::getTypes());
		$this->_view->render('discussions/add.phtml');
	}

	public function doAdd()
	{
		if (!is_ajax())
		{
			redirect(_url('/discussions/index/'));
		}

		try
		{
			Libs_Validator::setness($_POST, array('type', 'category', 'text'));
			Libs_Validator::emptyness($_POST, array('text'));
			Libs_Validator::discussionCategory($_POST['category']);
		}
		catch (Libs_Exceptions_NotPassedValidation $ex)
		{
			return send_form_error($ex->getData());
		}

		$model = new Models_Discussions();

		$data = $_POST;

		$data['user_id'] = Db_Currents::getUserInfo('id');
		$data['building_id'] = Db_Currents::getBuildingInfo('id');

		if (!$model->add($data))
		{
			return send_form_error(array('message' => 'unknow error'));
		}

		send_form_success();
	}
}