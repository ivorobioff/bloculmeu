<?php
class Controllers_Index extends Controllers_Common
{
	public function index()
	{
		if (!is_auth())
		{
			redirect_signin();
		}

		$this->_view->render('main/index.phtml');
	}
}