<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Layout extends Controller
{
	public $site = NULL;
    public $menu = NULL;
    public $side_menu = NULL;
    
    public $auth_user = NULL;
    
    public $sidebar = NULL;
	public $template = 'layout';

	public function before()
	{
        parent::before();
        Site::ini();
        Site::ssl();
        
        $this->auth_user = Auth::instance()->get_user();

		if ( ! $this->request->is_ajax())
		{
			
            if ( ! $this->auth_user AND $this->request->controller() != 'auth')
			{
				Session::instance()->set('refer_before_auth', Arr::get($_SERVER, 'REQUEST_URI', '/'));
			}

	       	//$this->site = Model::factory('site');
            $this->site = ORM::factory('site')->find();
			$this->template = View::factory($this->template);
	   	   	$this->template->bind_global('site', $this->site);
            $this->template->bind_global('menu', $this->menu);
            $this->template->bind_global('side_menu', $this->side_menu);
	   	   	$this->template->bind_global('auth_user', $this->auth_user);
	   	   	$this->template->bind_global('sidebar', $this->sidebar);
            
            $this->template->content = NULL;
		}

		$this->menu = strtolower(str_replace('Controller_', '', get_class($this)));
	}



} // End Controller Layout