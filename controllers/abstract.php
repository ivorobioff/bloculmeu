<?php
abstract class Controllers_Abstract
{
	protected $_view;

	public function __construct()
	{
		$this->_view = Libs_View::getInstance();
		$this->_view->setLayout('common/layout.phtml');
	}
}