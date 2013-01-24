<?php
class Libs_Validator
{
	static public function password($pass, $conf_pass, $length = 4)
	{
		if (strlen($pass) < 4)
		{
			throw new Libs_Exceptions_NotPassedValidation(array('password' => _t('/validator/password-too-short')));
		}

		if ($pass != $conf_pass)
		{
			throw new Libs_Exceptions_NotPassedValidation(array('password' => _t('/validator/password-not-mached')));
		}
	}

	static public function setness($data, $keys)
	{
		foreach ($keys as $value)
		{
			if (!isset($data[$value]))
			{
				throw new Libs_Exceptions_NotPassedValidation(array($value => _t('/validator/undefined')));
			}
		}
	}

	static public function emptyness($data, $keys)
	{
		foreach ($keys as $value)
		{
			$item = trim($data[$value]);

			if (!$item)
			{
				throw new Libs_Exceptions_NotPassedValidation(array($value => _t('/validator/empty')));
			}
		}
	}

	static public function email($email)
	{
		if (!preg_match('/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/', $email))
		{
			throw new Libs_Exceptions_NotPassedValidation(array('email' => _t('/validator/wrong-email')));
		}
	}
}