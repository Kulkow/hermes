<?php defined('SYSPATH') or die('No direct script access.');

class Model_Event_Type extends ORM {

    protected $_table_name = 'events_types';
    
    
    protected $_belongs_to = array(
    		/**
    		 * Владелец card
    		 */
    		'owner'		=> array(
    			'model'		=> 'user',
    		),
    	);
    
    public function rules()
	{
		return array(
			'code' => array(
				array('not_empty'),
				array('max_length', array(':value', 32)),
				array(array($this, 'unique'), array('code', ':value')),
			),
		);
	}
    
    public function url_admin($action)
	{
		return Site::url('/admin/event/type/'.$action.'/'.$this->id);
	}   
        

}