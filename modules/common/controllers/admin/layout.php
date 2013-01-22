<?php
namespace Controller\Common\Admin;

use System\Lib\Config;
use System\Lib\Http;
use Lib\Common\QuickMin;
use \System\Mvc\Controller as SystemController;
use Facade\Auth\Index as FacadeAuth;

class Layout extends SystemController
{
	protected $_default_layout = 'common/admin/layout.phtml';

	public function _initPage()
	{
		if (!FacadeAuth::getInstance()->isAuth())
		{
			Http::redirect('/'.get_admin_name().'/auth/');
		}

		QuickMin::run();

		$this->_view->title = 'BMWHouse 1.0s';
		$this->_view->page_title = '';

		$user_info =  FacadeAuth::getInstance()->getUser();
 		$this->_view->username = htmlspecialchars(ucfirst($user_info['username']));
	}
}