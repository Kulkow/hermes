<?php defined('SYSPATH') or die('No direct script access.');

class Model_Page_Content extends ORM
{
	protected $_belongs_to = array('page' => array('model' => 'page'));

	public function rules()
	{
		return array(
			'h1' => array(
				array('max_length', array(':value', 512)),
			),
		);
	}
}