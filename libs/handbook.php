<?php
class Libs_Handbook
{
	static public function getDisscusionCategories()
	{
		return array(
			'message' => _t('/discussions/categories/message'),
			'survey' =>  _t('/discussions/categories/survey'),
			'offer' =>  _t('/discussions/categories/offer'),
			'problem' =>  _t('/discussions/categories/problem')
		);
	}
}