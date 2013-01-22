<?php
namespace Model\Modules\Admin;

use Lib\Modules\InstalledResults;
use Lib\Modules\InstalledRows;
use Lib\Modules\GridRows;
use Lib\Modules\Rows;
use Db\Modules\Modules as TableModules;
use System\Exceptions\Exception as SystemException;
use System\Mvc\Model as SystemModel;
use Lib\Modules\Results;
use Lib\Modules\GridResults;

class Modules extends SystemModel
{
	const MODULE_GUID_NOT_SAVED = 1;

	protected function _getTable()
	{
		return new TableModules();
	}

	/**
	 * Получаем список всех установленных не установленных модулей.
	 * Если модуль установлен, то данные модуля берутся с базы
	 * @see System\Mvc.Model::getAll()
	 */
	public function getAll()
	{
		$from_files = $this->_getAllFromFiles();

		$res = array();

		foreach ($from_files as $from_file)
		{
			$res[]  = $this->_mergeModules($from_file, $this->_getInstalled(always_set($from_file, 'guid'))->toArray());
		}

		return $res;
	}

	/**
	 * (non-PHPdoc)
	 * @see System\Mvc.Model::get()
	 */
	public function get()
	{
		$from_file = $this->_getFromFile($this->_id);

		return $this->_mergeModules($from_file, $this->_getInstalled(always_set($from_file, 'guid'))->toArray());
	}

	public function getAll4Grid()
	{
		return new GridResults($this->getAll());
	}

	public function get4Grid()
	{
		return new GridRows($this->get());
	}

	public function getAllInstalled()
	{
		return new InstalledResults($this->_table->fetchAll());
	}

	/**
	 * Получаем установленый модуль по guid
	 * @param string $guid
	 * @return array
	 */
	private function _getInstalled($guid)
	{
		if (!$guid)
		{
			return array();
		}

		return  new InstalledRows($this->_table->fetchOne('guid', $guid));
	}

	public function install($data)
	{
		$guid = gen_guid();

		$item = array(
			'title' => $data['info']['title'],
			'description' => $data['info']['description'],
			'menu' => serialize($data['menu']),
			'guid' => $guid
		);

		$this->_table->insert($item);

		$this->_saveGUID($guid, root_path().'/modules/'.$data['name']);
	}

	public function uninstall()
	{
		if (!$guid = always_set($this->get(), 'guid'))
		{
			return false;
		}

		$this->_table->delete('guid', $guid);
	}

	public function pin()
	{
		if (!$guid = always_set($this->get(), 'guid'))
		{
			return false;
		}

		$this->_table
			->where('guid', $guid)
			->update('pin=IF(pin=1, 0, 1)');
	}

	private function _getAllFromFiles()
	{
		$modules = array();

		$dirs = new \DirectoryIterator(root_path().'/modules');

		foreach ($dirs as $dir)
		{
			if ($dir->isDir())
			{
				$module = $this->_getFromFile($dir->getFilename());

				if ($module)
				{
					$modules[] = $module;
				}
			}
		}

		return $modules;
	}

	private function _getFromFile($name)
	{
		$path = root_path().'/modules/'.$name;

		if (!file_exists($path))
		{
			return array();
		}

		$conf = $path.'/config.php';

		if (!file_exists($conf))
		{
			return array();
		}

		include $conf;

		$guid = $this->_fetchGUID($path);

		$res = array(
			'info' => $info,
			'menu' => $menu,
			'name' => $name,
			'pin' => 0,
		);

		if ($guid)
		{
			$res['guid'] = $guid;
		}

		return $res;
	}

	private function _fetchGUID($path)
	{
		$guid = false;

		$guid_file = $path.'/.guid';

		if (file_exists($guid_file))
		{
			$guid = trim(file_get_contents($guid_file));
		}

		return $guid;
	}

	private function _saveGUID($guid, $path)
	{
		$guid_path =  $path.'/.guid';

		if(file_put_contents($guid_path, $guid) === false)
		{
			throw new SystemException('GUID модуля "'.$name.'" небыл сохранен', self::MODULE_GUID_NOT_SAVED);
		}
	}

	private function _mergeModules(array $from_file, array $installed)
	{
		if (!$from_file)
		{
			return array();
		}

		unset($from_file['guid']);

		if (!$installed)
		{
			return $from_file;
		}

		$from_file['info']['title'] = $installed['title'];
		$from_file['info']['description'] = $installed['description'];
		$from_file['pin'] = $installed['pin'];
		$from_file['menu'] = $installed['menu'];
		$from_file['guid'] = $installed['guid'];

		return $from_file;
	}
}