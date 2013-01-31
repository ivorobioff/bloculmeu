<?php
class Controllers_Messages extends Controllers_Common
{
	public function index($parmas = array())
	{
		$this->_view->render('messages/index.phtml');
	}
}