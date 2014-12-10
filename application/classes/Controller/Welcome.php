<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller_Layout {

	public function before()
	{
	   parent::before();
	}
       
    public function action_index()
	{
	   $this->template->content = View::factory('auth/registr/success');
	}
    
    public function action_ms()
	{
        $this->template->content = View::factory('index');
	}

} // End Welcome
