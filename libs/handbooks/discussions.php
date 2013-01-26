<?php
class Libs_Handbooks_Discussions
{
	static public function getCategories()
	{
		return array(
			'message' => _t('/discussions/categories/message'),
			'survey' =>  _t('/discussions/categories/survey'),
			'offer' =>  _t('/discussions/categories/offer'),
			'problem' =>  _t('/discussions/categories/problem')
		);
	}

	static public function getTypes()
	{
		return array(
			'0' => _t('/discussions/types/inner'),
			'1' => _t('/discussions/types/outter')
		);
	}
}