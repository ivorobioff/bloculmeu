<?php
abstract class Controllers_Common
{
	protected $_view;

	protected $_require_auth = true;
	protected $_auth_exceptions = array();

	public function __construct()
	{
		$this->_checkAuth();
		$this->_view = Libs_View::getInstance();
		$this->_view->assign('title', 'Bloculmeu 1.0');
		$this->_view->setLayout('common/layout.phtml');

		if (is_auth())
		{
			$building_address =  Db_Currents::getBuildingInfo('name').' '. Db_Currents::getBuildingInfo('number');
			$this->_view->assign('fio', Db_Currents::getUserInfo('fio'));
			$this->_view->assign('current_building_id', Db_Currents::getBuildingInfo('id'));
			$this->_view->assign('current_building_address', $building_address);
		}
	}

	private function _checkAuth()
	{
		$auth_exceptions = $this->_auth_exceptions;

		foreach ($auth_exceptions as &$value)
		{
			$value = strtolower($value);
		}

		if ($this->_require_auth)
		{
			if (!in_array($_GET['action'], $auth_exceptions) && !is_auth())
			{
				redirect_signin();
			}
		}
		else
		{
			if (in_array($_GET['action'], $auth_exceptions) && !is_auth())
			{
				redirect_signin();
			}

		}
	}
}
