<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Checks extends Controller_Admin_Layout
{

    public $sort = 'created';
    public $up = 'desc';
    
    public $session = NULL;
    
    public $search = NULL;
    
    public $checks = NULL;
    
    public function before()
    {
       // ORM::factory('user', array('login' => '2770003000001'))->values(array('password', '111777'))->update();
        parent::before();
        $this->session = Session::instance();
        $this->checks = ORM::factory('check')->find_all();
        
        foreach($this->checks as $check)
        {
            print_r($check->as_array());
        }
        
        
        
    }
    
    public function action_index()
	{
           
                                   
		$this->template->content = 'checks';
	}
    
    
    
 }       