<?php defined('SYSPATH') or die('No direct script access.');

class Model_Log extends ORM {

    protected $_table_name = 'logs';
    
    
    protected $_belongs_to = array(
    		/**
    		 * кто совершил
    		 */
    		'user'		=> array(
    			'model'		=> 'user',
    		),
    	);
        
    /*protected $_has_many = array(
            'events' => array(
                'through' => 'cards_events'),
    );*/
    
    
    public function rules()
	{
		return array(
			'action' => array(
				array('not_empty'),
			),
		);
	}
    
    public function filters()
	{
		return array(
           
           /* 'active_time' 	=> array(
				array('strtotime'),
			),*/
		);
	}
    
    public function add_action($user = NULL, $action, $target = NULL, $content = '')
    {
        $log = ORM::factory('log');
        try
        {
             $values = array('action' => $action);
             $log->values($values);
             if($target instanceof ORM) 
             {
                $tostr = $target->model().'/'.$target->id;
                $log->target = $tostr;
             }
             if($user)
             {
                $log->user = $user;
             }
             $log->ip = Request::$client_ip;
             $log->created = time();
             $log->content = $content;
             $log->create();
        }
        catch (ORM_Validation_Exception $e)
        {
    	    $errors = $e->errors('log');
        }
    }
    public function target()
    {
        if($this->loaded() AND $this->target)
        {
            $_targets = explode('/',$this->target);
            if(count($_targets) == 2)
            {
                list($model, $id) = $_targets;
                return $model.'/'.$id;
            }
        }
        return FALSE;
    }
}    
    