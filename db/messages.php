<?php
class Db_Messages extends Libs_ActiveRecord
{
	protected $_table_name = 'messages';

	public function insert(array $data)
	{
		$data['insert_date'] = date('Y-m-d H:i:s');
		return parent::insert($data);
	}
}