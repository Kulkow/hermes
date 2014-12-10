<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Blacklist extends ORM {
    
	protected $_table_name = 'black_list';
    
    public function url_admin($action)
	{
		return Site::url('/admin/blacklist/'.$action.'/'.$this->id);
	}
    
    
    public function rules()
	{
		return array(
			'ip' => array(
				array('not_empty'),
			),
		);
	}
    
    
}