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

		$data = $_POST;

		$data['fio'] = trim($data['fio']);

		$model = new Models_Users();

		if (!$model->add($data))
		{

		}
	}
}