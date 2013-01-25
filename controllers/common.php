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
	}

	private function _checkAuth()
	{
		if ($this->_require_auth)
		{
			if (!in_array($_GET['action']) && !is_auth())
			{
				redirect_signin();
			}
		}
		else
		{
			if (in_array($_GET['action']) && !is_auth())
			{
				redirect_signin();	
			}
			
		}
	}
}
