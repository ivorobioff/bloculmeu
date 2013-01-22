<?php
namespace Model\Common\Admin;

use Db\Common\Admin\GridTest as TableGridTest;
use Model\Modules\Admin\Modules as ModelModules;
use Model\Common\Admin\Grid as CommonGrid;

class GridTest extends CommonGrid
{
	protected function _prepareSource()
	{
		$this->_source = new TableGridTest();
	}

	protected function _count()
	{
		return $this->_source
			->select('COUNT(*) AS c')
			->getValue('c');
	}

	protected function _getRows()
	{
		list($offset, $limit) = $this->_getRange();

		return $this->_source
			->orderBy('`'.$this->_state['order_by'].'`', $this->_state['order'])
			->limit($offset, $limit)
			->fetchAll();
	}
}
