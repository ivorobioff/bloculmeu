<?php
namespace Plugins\Minimizer;

use \Plugins\Minimizer\JSMin;
use \Plugins\Minimizer\JSMinException;
use \Plugins\Minimizer\Exception;
use \System\Lib\Server;
/**
 * Класс для объединения и минимизации всех js добавленых в стэк.
 * @author Igor Vorobioff<i_am_vib@yahoo.com>
 */
class Minimizer
{
	private $_xml;

	private $_output = '';

	private $_admin_output = '';

	private $_is_admin;

	public function __construct($xml, $is_admin = false)
	{
		$this->_is_admin = $is_admin;
		$this->_loadXML(trim($xml, '/'));
	}


	public function process($minify_on = true)
	{
		$js_min = '';

		$files = $this->_getFiles();

		$this->_output = Server::get('document_root').$this->_xml->load->attributes()->output;
		$this->_admin_output = Server::get('document_root').$this->_xml->load->attributes()->admin_output;


		foreach ($files as $file)
		{
			$file = Server::get('document_root').$file;

			if (!file_exists($file))
			{
				throw new Exception('Cannot load the script file: '.$file);
			}

			try
			{
				$js_min .= $minify_on ? JSMin::minify(file_get_contents($file)) : file_get_contents($file)."\n";
			}
			catch (JSMinException $ex)
			{
				throw new Exception($ex->getMessage());
			}
		}

		$this->_saveJS($js_min);
	}

	private function _getFiles()
	{
		$files = array();

		$base_path = '';

		foreach ($this->_xml->load->group as $group)
		{
			if ($this->_is_admin)
			{
				if (!$group->attributes()->admin && !$group->attributes()->admin_only)
				{
					continue ;
				}
			}
			else
			{
				if ($group->attributes()->admin_only)
				{
					continue ;
				}
			}

			$base_path = $group->attributes()->base_path;

			foreach ($group->js as $js)
			{
				$files[] = $base_path.'/'.trim($js->attributes()->src, '/');
			}
		}

		return $files;
	}


	private function _loadXML($xml)
	{
		if (!file_exists($xml))
		{
			throw new Exception('Cannot locate the config file.');
		}

		if (!$this->_xml = simplexml_load_file($xml))
		{
			throw new Exception('Cannot load the xml file: '.$xml);
		}
	}

	private function _saveJS($str)
	{
		$real_output = $this->_is_admin ? $this->_admin_output : $this->_output;

		if (!file_put_contents($real_output, $str))
		{
			throw new Exception('Cannot save into file: '.$real_output);
		}
	}
}