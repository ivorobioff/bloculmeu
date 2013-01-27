<?php
class Controllers_Neighbors extends Controllers_Common
{
	public function index()
	{
		$model = new Models_Neighbors();
		$this->_view->assign('neighbors_list', $model->get4Main());
		$this->_view->render('neighbors/index.phtml');
	}
}