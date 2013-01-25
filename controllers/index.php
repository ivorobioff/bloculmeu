<?php
class Controllers_Index extends Controllers_Common
{
	public function index()
	{
		$this->_view->render('main/index.phtml');
	}
}
