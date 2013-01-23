<?php
class Controllers_Index extends Controllers_Abstract
{
	public function index()
	{
		$this->_view->assign('title', 'Fuck yeah');
		$this->_view->render('main/index.phtml');
	}
}