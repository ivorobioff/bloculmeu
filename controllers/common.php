<?php
abstract class Controllers_Common
{
	protected $_view;

	public function __construct()
	{
		$this->_view = Libs_View::getInstance();
		$this->_view->assign('title', 'Bloculmeu 1.0');
		$this->_view->setLayout('common/layout.phtml');
	}
}