<?php
class Db_Discussions extends Libs_ActiveRecord
{
	protected $_table_name = 'discussions';

	public function insert(array $data)
	{
		$data['insert_date'] = date('Y-m-d H:i:s');
		return parent::insert($data);
	}

	public function update($data, $value = null)
	{
		$data['update_date'] = date('Y-m-d H:i:s');
		return parent::update($data, $value);
	}
}