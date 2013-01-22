<?php
namespace Controller\Common;

use Lib\Common\QuickMin;
use \System\Mvc\Controller as SystemController;

class Layout extends SystemController
{
	protected $_default_layout = 'common/layout.phtml';

	public function _initPage()
	{
		QuickMin::run();

		$this->_view->title = 'BMWHouse 1.0';
	}

	protected function _setLabels(array $labels)
	{
		$this->_view->front_labels = json_encode($labels);
	}
}