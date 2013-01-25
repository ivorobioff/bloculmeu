<?php
class Controllers_Error404 extends Controllers_Common
{
	protected $_require_auth = false;

	public function show()
	{
		echo 'error404';
	}
}