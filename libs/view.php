<?php
class Libs_View
{
	static private $_INSTANCE = null;

	private $_params = array();

	private $_layout = '';
	private $_view = '';

	/**
	 * @return Libs_View
	 */
	static public function getInstance()
	{
		if (self::$_INSTANCE == null)
		{
			self::$_INSTANCE = new self();
		}

		return self::$_INSTANCE;
	}

	public function assign($key, $value)
	{
		$this->_params[$key] = $value;
	}

	public function render($path = '')
	{
		$path = trim(trim($path, '/'));

		if ($path)
		{
			$this->_view =  BASE_DIR.'/views/'.$path;
		}

		include_once  $this->_layout;

		$this->_clear();
	}

	public function setLayout($path)
	{
		$this->_layout = BASE_DIR.'/views/'.$path;
	}

	public function view()
	{
		if (!$this->_view)
		{
			return ;
		}

		include_once $this->_view;
	}

	public function block($path, $params = array())
	{
		include BASE_DIR.'/views/'.$path;
	}

	private function _clear()
	{
		$this->_params = array();
		$this->_view = '';
	}
}