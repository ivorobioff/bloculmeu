<?php
class Controllers_Users extends Controllers_Common
{
	public function signup()
	{
		$this->_view->render('users/signup.phtml');
	}

	public function signin()
	{
		$this->_view->render('users/signin.phtml');
	}

	public function logout()
	{
		unset($_SESSION['user']);

		include BASE_DIR.'/config/defaults.php';

		$url = '/'.$defaults_config['location']['controller'].'/'.$defaults_config['location']['action'].'/';

		redirect($url);
	}

	public function doSignup()
	{
		if (!is_ajax())
		{
			return ;
		}

		try
		{
			Libs_Validator::setness($_POST, array('fio', 'email', 'password', 'conf_password'));
			Libs_Validator::emptyness($_POST, array('fio', 'email'));
			Libs_Validator::password($_POST['password'], $_POST['conf_password']);
			Libs_Validator::email($_POST['email']);
		}

		catch (Libs_Exceptions_NotPassedValidation $ex)
		{
			return send_form_error($ex->getData());
		}

		$model = new Models_Users();

		if ($model->checkEmail($_POST['email']))
		{
			return send_form_error(array('email' => _t('/signup/email-busy')));
		}

		$data = array(
			'email' => $_POST['email'],
			'password' => md5( $_POST['password'])
		);

		if (!$model->add($data))
		{
			return send_form_error(array('message' => 'unkown error'));
		}

		return send_form_success();
	}
}