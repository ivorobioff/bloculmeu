<?php
class Controllers_Discussions extends Controllers_Common
{
	public function index()
	{
		$this->_view->assign('discussion_categories', Libs_Handbook::getDisscusionCategories());
		$this->_view->render('discussions/index.phtml');
	}

	public function add($params = array())
	{
		if (!in_array(always_set($params, 0, ''), array_keys(Libs_Handbook::getDisscusionCategories())))
		{
			redirect(_url('/discussions/index/'));
		}

		$this->_view->render('discussions/add.phtml');
	}
}