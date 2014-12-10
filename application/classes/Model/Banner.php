<?php defined('SYSPATH') or die('No direct script access.');

class Model_Banner extends ORM {

    protected $_table_name = 'banners';
    
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
		return Site::url('/admin/banner/'.$action.'/'.$this->id);
	}

}