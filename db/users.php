<?php
class Db_Users extends Libs_ActiveRecord
{
	protected $_table_name = 'users';

	public function insert(array $data)
	{
		$data['insert_date'] = date('Y-m-d H:i:s');
		return parent::insert($data);
	}
}