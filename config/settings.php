<?php
/**
 * Настройка БД
 */
$config['DB'] = array(
	'host' => 'localhost',
	'username' => 'root',
	'password' => '1234',
	'dbname' => 'bmwhouse'
);

$config['DEFAULT_PATH'] = '/home/'; //путь по умолчанию
$config['DEFAULT_ADMIN_PATH'] = '/modules/index/pins'; // путь по умолчанию в админке
$config['ADMIN_NAME'] = 'admin'; //имя админки. т.е. чтоб попасть в админку надо http://{domain}.com/admin/