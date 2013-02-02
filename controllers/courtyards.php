<?php
class Controllers_Courtyards extends Controllers_Common
{
	public function index()
	{
		$model = new Models_Buildings();
		$model_courtyards = new Models_Courtyards();

		$this->_view->assign('buildings_list', $model_courtyards->get4Main());
		$this->_view->assign('streets', $model->getStreets());
		$this->_view->assign('suggestions_list', $model_courtyards->getSuggestions());
		$this->_view->render('courtyards/index.phtml');
	}

	public function addBuilding()
	{
		if (!is_ajax())
		{
			return false;
		}

		try
		{
			Libs_Validator::setness($_POST, array('street', 'number'));
			Libs_Validator::emptyness($_POST, array('street', 'number'));
		}
		catch (Libs_Exceptions_NotPassedValidation $ex)
		{
			return send_form_error($ex->getData());
		}

		$model_building = new Models_Buildings();

		if (!$building = $model_building->getByAddress($_POST['street'], $_POST['number']))
		{
			return send_form_error(array('message' => 'unknown error'));
		}

		if ($building['id'] == Db_Currents::getBuildingInfo('id'))
		{
			return send_form_error(array('street' => _t('/courtyards/users-building')));
		}

		$model_courtyard = new Models_Courtyards();

		if ($model_courtyard->checkBuilding($building['id']))
		{
			return send_form_error(array('street' => _t('/courtyards/building-exists')));
		}

		if (!$model_courtyard->add($building['id']))
		{
			return send_form_error(array('message' => 'unknown error'));
		}

		$item = $model_courtyard->getItem4Main($building['id']);
		send_form_success(array('html' => $this->_view->block('courtyards/item.phtml', $item, false)));
	}
}