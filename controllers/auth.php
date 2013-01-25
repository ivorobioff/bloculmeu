<?php
class Controllers_Auth extends Controllers_Common
{
	public function signup()
	{
		if (is_auth())
		{
			redirect_home();
		}

		$this->_view->render('auth/signup.phtml');
	}

	public function signin()
	{
		if (is_auth())
		{
			redirect_home();
		}

		if ($hashed_id = always_set($_COOKIE, 'remember_me', false))
		{
			$model = new Models_Users();

			if ($data = $model->getByHashedId($hashed_id))
			{
				$_SESSION['user'] = $data;
				redirect(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/');
			}
		}

		$this->_view->render('auth/signin.phtml');
	}

	public function logout()
	{
		unset($_SESSION['user']);

		$domain = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : null;
		setcookie('remember_me', '', time()-3600, '/', $domain);

		redirect_signin();
	}

	public function doSignin()
	{
		if (!is_ajax())
		{
			redirect(_url('/auth/signin/'));
		}

		try
		{
			Libs_Validator::setness($_POST, array('email', 'password'));
			Libs_Validator::emptyness($_POST, array('email', 'password'));
			Libs_Validator::email($_POST['email']);
		}

		catch (Libs_Exceptions_NotPassedValidation $ex)
		{
			return send_form_error($ex->getData());
		}

		$model = new Models_Users();

		if (!$data = $model->get4Auth($_POST['email'], $_POST['password']))
		{
			return send_form_error(array('email' => _t('/signin/no-user-found')));
		}

		if (isset($_POST['remember_me']))
		{
			$domain = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : null;

			setcookie('remember_me', md5($data['id']), time() + (86400 * 31), '/', $domain);
		}

		$_SESSION['user'] = $data;

		return send_form_success();
	}

	public function doSignup()
	{
		if (!is_ajax())
		{
			redirect(_url('/auth/signup/'));
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

		if (!$model->add($_POST))
		{
			return send_form_error(array('message' => 'unkown error'));
		}

		return send_form_success();
	}
}