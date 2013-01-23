<?php
function __autoload($class)
{
	$file = BASE_DIR.'/'.strtolower(str_replace('_', '/', $class.'.php'));

	if (file_exists($file))
	{
		require_once  $file;
	}
}
