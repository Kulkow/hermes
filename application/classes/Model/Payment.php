<?php defined('SYSPATH') or die('No direct script access.');

class Model_Payment extends ORM {

    
    public function rules()
	{
		return array(
			'alias' => array(
				array('not_empty'),
				array('max_length', array(':value', 32)),
				array(array($this, 'unique'), array('alias', ':value')),
			),
            'login' => array(
				array('not_empty'),
			),
            'password' => array(
				array('not_empty'),
			),
		);
	}
    
    public function url_admin($action)
	{
		return Site::url('/admin/payment/'.$action.'/'.$this->id);
	}

}