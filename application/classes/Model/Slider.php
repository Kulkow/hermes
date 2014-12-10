<?php defined('SYSPATH') or die('No direct script access.');

class Model_Slider extends ORM {

    protected $_table_name = 'slider';
    
    protected $_belongs_to = array(
    		'image'		=> array(
    			'model'		=> 'image',
    		),
    	);
    
    public function url()
    {
        return ($this->url ? $this->url : Site::url('/'));
    }
    
    public function url_admin($action)
	{
		return Site::url('/admin/slider/'.$action.'/'.$this->id);
	}

}