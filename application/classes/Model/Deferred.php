<?php defined('SYSPATH') or die('No direct script access.');

class Model_Deferred extends ORM {

    protected $_table_name = 'deferred';
    
    
    protected $_belongs_to = array(
    		/**
    		 */
    		'user'		=> array(
    			'model'		=> 'user',
    		),
            'type'		=> array(
    			'model'		=> 'event_type',
    		),
    	);
   
   public function operation()
    {
        if($this->loaded())
        {
            if($this->type)
            {
               if($this->type->loaded())
               {
                  return $this->type->title;
               }   
            }
        }
        return FALSE;
    }
    
   public function create_event($values)
   {
      
      //ORM::
   }
   
   /* 
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
    */
    
    /*
    public function filters()
	{
		return array(
		            'active_time' 	=> array(
				array('strtotime'),
			),
		);
	}
    */
    
   
    
    public function url_admin($action)
	{
		return Site::url('/admin/deferred/'.$action.'/'.$this->id);
	}

	public function url()
	{
		//return Site::url('/udeferredser/'.$this->login.'');
	}
    
    public function clear_tresh($user = NULL)
	{
	   if(! $user)
       {
           return FALSE;
       }
       
       if(TRUE)
       {
           $user_id = $user;
           if($user instanceof ODM)
           {
              if(! $user->loaded())
              {
                return FALSE;
              }
              $user_id = $user->id;
           }
           $accrual = time();
           $delete = DB::query(Database::DELETE, 'DELETE FROM `'.$this->_table_name.'` WHERE `user_id`=:user_id AND `accrual` < :accrual')->bind(':user_id', $user_id)->bind(':accrual', $accrual);
           $delete->execute();
       }
	}
    
    
    public function last_event()
    {
        if (! $this->last_event)
        {
            return false;
        }
        /*
        $event = ORM::factory('event', $this->last_event);
        return View::factory('admin/event/preview')->bind('event', $event)->render();
        */
    }



}