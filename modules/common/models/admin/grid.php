<?php
namespace Model\Common\Admin;

use System\Lib\Http;

abstract class Grid
{
	protected $_state = array();

	protected $_source;

	public function __construct()
	{
		$this->_setState();
		$this->_prepareSource();
	}

	abstract protected function _prepareSource();
	abstract protected function _count();
	abstract protected function _getRows();

	protected function _getTotalPages()
	{
		$count = $this->_count();

		if (!$count)
		{
			return 1;
		}

		return ceil($count / $this->_state['rows_per_page']);
	}

	protected function _getRange()
	{
		$offset = ($this->_state['current_page'] * $this->_state['rows_per_page']) - $this->_state['rows_per_page'];

		$limit =  $this->_state['rows_per_page'];

		return array($offset, $limit);
	}

	protected function _setState()
	{
		$this->_state = array(
			'current_page' => Http::request('current_page', 1),
			'rows_per_page' => Http::request('rows_per_page', 10),
			'order' => Http::request('order', 'asc'),
			'order_by' => Http::request('order_by', 'id')
 		);
	}

	protected function _getFinalState()
	{
		$state = $this->_state;
		$state['total'] = $this->_count();

		return $state;
	}

	public function getData()
	{
		return array(
			'state' => $this->_getFinalState(),
			'rows' => $this->_getRows(),
		);
	}
}