<?php
namespace System\Lib;

use \System\Lib\Config;
use \System\Lib\Server;

/**
 * Рутер.
 * Класс управляет приходящими запросами.
 * Создает нужный объект контроллера и передает ему контроль над системой.
 *
 * @author Igor Vorobioff<i_am_vib@yahoo.com>
 */
class Router
{
	/**
	 * Разбитый URL путь.
	 * 										!!!ВАЖНО!!!
	 * Массив не должен потерять ни одного сегмента и должен соответствовать полученному URL.
	 * @var array
	 */
	private $_array_path;

	static private $_instance;

	public function __construct($url)
	{
		$this->_parseUrl($url);
	}

	static public function getInstance()
	{
		if (!isset(self::$_instance))
		{
			self::$_instance = new self(Server::get('REQUEST_URI'));
		}

		return self::$_instance;
	}

	/**
	 * Получаем текущий путь и последующие параметры в массиве.
	 * @return array
	 */
	public function getArrayPath()
	{
		$path = $this->_array_path;

		if ($this->isAdmin())
		{
			if (count($path) < 2)
			{
				$path = $this->_array_path = explode('/', 'admin/'.trim(Config::getInstance()->getSettings('DEFAULT_ADMIN_PATH'), '/'));
			}

			unset($path[0]);

			$path = array_merge(array(), $path);
		}

		$path[1] = always_set($path, 1, 'index');
		$path[2] = always_set($path, 2, 'index');

		return $path;
	}

	public function isAdmin()
	{
		return $this->_getType() == Config::getInstance()->getSettings('ADMIN_NAME');
	}

	/**
	 * Парсит url
	 * @param string $url
	 */
	private function _parseUrl($url)
	{
		$path = trim(trim($url), '/');

		if ($path == '')
		{
			$path = Config::getInstance()->getSettings('DEFAULT_PATH');
		}

		$path = explode('?', $path);

		$query = always_set($path, 1, false);

		$path = $path[0];

		if ($query)
		{
			parse_str($query, $_GET);
		}

		$path = trim(trim($path), '/');

		$this->_array_path = explode('/', $path);
	}

	/**
	 * Возвращает первое значение сигмента url.
	 * Служит отличительным признаком запроса.
	 * @return string
	 */
	private function _getType()
	{
		return $this->_array_path[0];
	}

	/**
	 * Создает и передает управление стандартным контроллерам
	 * @throws \System\Exceptions\Error404 - в случае если контроллер или действие не найдено
	 */
	private function _standardController()
	{
		list ($module_name, $controller_name, $action_name) = $this->getArrayPath();

		$action_name = $this->_prepareAction($action_name);

		$controller_file = root_path().'/modules/'.$module_name.'/controllers/'.$controller_name.'.php';

		if ($this->isAdmin())
		{
			$controller_file = root_path().'/modules/'.$module_name.'/controllers/admin/'.$controller_name.'.php';
		}

		if (!file_exists($controller_file))
		{
			throw new \System\Error404\Exception();
		}

		$controller_class = 'Controller\\'.$module_name.'\\'.$controller_name;

		if ($this->isAdmin())
		{
			$controller_class = 'Controller\\'.$module_name.'\\Admin\\'.$controller_name;
		}

		$controller = new $controller_class();

		if (!method_exists($controller, $action_name))
		{
			throw new \System\Error404\Exception();
		}

		try
		{
			$controller->{$action_name}();
		}
		catch (\System\Exceptions\Controller $ex)
		{
			$ex->load();
		}
	}

	/**
	 * Контроллер общих тестов
	 * @throws \System\Exceptions\Error404
	 */
	private function _ctestController()
	{
		$module_name = always_set($this->_array_path, 0);
		$test_case_name = always_set($this->_array_path, 1);

		$this->_runTest(array(
			'module_name' => $module_name,
			'test_case_name' => $test_case_name,
			'test_case_path' => root_path().'/tests/'.$test_case_name.'.php',
			'test_case_class' => 'Ctest\\'.$test_case_name
		));
	}

	/**
	 * Контроллер модульных тестов
	 * @throws \System\Exceptions\Error404
	 */
	private function _testController()
	{
		$module_name = always_set($this->_array_path, 1);
		$test_case_name = always_set($this->_array_path, 2);

		$this->_runTest(array(
			'module_name' =>  $module_name,
			'test_case_name' => $test_case_name,
			'test_case_path' => root_path().'/modules/'.$module_name.'/tests/'.$test_case_name.'.php',
			'test_case_class' => 'Test\\'.$module_name.'\\'.$test_case_name
		));
	}

	/**
	 * Создает контроллер которой возмет под контроль тест кейс
	 * @param array $config
	 * @throws \System\Error404\Exception
	 */
	private function _runTest(array $config)
	{
		$module_name = always_set($config, 'module_name');
		$test_case_name = always_set($config, 'test_case_name');

		if (!$module_name || !$test_case_name)
		{
			throw new \System\Error404\Exception();
		}

		$test_case_path = always_set($config, 'test_case_path', '');
		$test_case_class = always_set($config, 'test_case_class', '');

		if (!file_exists($test_case_path))
		{
			throw new \System\Error404\Exception();
		}

		$controller_class = 'System\Test\Controller';

		$controller = new $controller_class($test_case_class);

		$controller->{'run'}();
	}

	/**
	 * Уберает "-" из $action для того чтоб можно было вызвать как функцию
	 * @param string $action
	 */
	private function _prepareAction($action)
	{
		return str_replace('-', '', $action);
	}

	/**
	 * Запускает механизм рутинга.
	 * Вначале проверяет если есть какие-то зарезервированные типы контроллеров.
	 * Если нет, то создает стандартный контроллер.
	 */
	public function run()
	{
		$method = '_'.$this->_getType().'Controller';

		if (method_exists($this, $method))
		{
			$this->$method();
			return true;
		}

		$this->_standardController();
	}
}