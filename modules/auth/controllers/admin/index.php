<?php
namespace Controller\Auth\Admin;

use Plugins\Validator\Validator;

use \System\Mvc\Controller as SystemController;
use \Facade\Auth\Index as FacadeAuth;
use \Lib\Common\QuickMin;
use \System\Lib\Http;
use Plugins\Validator\Rules\Email;

class Index extends SystemController
{
	protected $_default_layout = 'auth/admin/index.phtml';

	protected function _initPage()
	{
		QuickMin::run();
	}

	public function index()
	{
		$this->_render();
	}

	public function login()
	{
		$this->_mustBeAjax();

		$data = Http::post();

		$validator_rules = array(
			'email' => new Email('Не верный формат почты'),
			'password' => true,
		);

		if(!Validator::isValid($data, $validator_rules))
		{
			return $this->_sendError(Validator::fetchErrors());
		}

		if (!FacadeAuth::getInstance()->login($data['email'], $data['password']))
		{
			return	$this->_sendError(array('Неверный логин или пароль.'));
		}

		return $this->_sendSimpleResponse(array('url' => '/'.get_admin_name().'/'));
	}

	public function logout()
	{
		FacadeAuth::getInstance()->logout();
		Http::redirect('/'.get_admin_name().'/auth/');
	}
}