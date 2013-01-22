<?php
namespace Controller\Modules\Admin;

use Model\Modules\Admin\Grid as ModulesGrid;
use Controller\Common\Admin\Layout;
use \System\Lib\Http;
use \Model\Modules\Admin\Modules as ModelModules;

class Index extends Layout
{
	const MODULE_NO_NAME = 'Не задано имя модуля';

	public function pins()
	{
		$this->_view->page_title = 'Важные модули';

		$this->_render('modules/admin/pins.phtml');
	}

	public function managment()
	{
		$this->_view->page_title = 'Управление модулями';

		$this->_render('modules/admin/managment.phtml');
	}

	public function readModules()
	{
		$this->_mustBeAjax();

		$grid = new ModulesGrid();
		$this->_sendSimpleResponse($grid->getData());

	}

	public function install()
	{
		if (!$name = Http::post('name', false))
		{
			return $this->_sendError(array(self::MODULE_NO_NAME));
		}

		$module = new ModelModules($name);

		if (!$data = $module->get())
		{
			return $this->_sendError(array('Модуль не найден'));
		}

		if (isset($data['guid']))
		{
			return $this->_sendError(array('Модуль уже установлен'));
		}

		$module->install($data);

		return $this->_sendResponse($module->get4Grid()->toArray());
	}

	public function uninstall()
	{
		if (!$name = Http::post('name', false))
		{
			return $this->_sendError(array(self::MODULE_NO_NAME));
		}

		$module = new ModelModules($name);
		$module->uninstall();

		return $this->_sendResponse($module->get4Grid()->toArray());
	}

	public function refresh()
	{
		if (!$name = Http::post('name', false))
		{
			return $this->_sendError(array(self::MODULE_NO_NAME));
		}

		$module = new ModelModules($name);

		$data = $module->get();

		if (!always_set($data, 'guid'))
		{
			return $this->_sendError(array('Модуль не установлен.'));
		}

		$module->uninstall();

		$data = $module->get();
		$module->install($data);

		return $this->_sendResponse($module->get4Grid()->toArray());
	}

	public function pin()
	{
		if (!$name = Http::post('name', false))
		{
			return $this->_sendError(array('Не задано имя модуля'));
		}

		$module = new ModelModules($name);

		$module->pin();

		return $this->_sendResponse($module->get4Grid()->toArray());
	}
}