<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Admin_Kohana_Layout extends Controller
{
	public $site = NULL;
	public $menu = NULL;
    public $template = 'admin/layout';
    public $auth_user = FALSE;

	public function before()
	{
        if (HTTP_Request::POST == $this->request->method() AND ! Security::check($this->request->post('token')))
		{
			$this->error('csrf');
		}

		//$this->auth_user = Auth::user();
        $this->auth_user =  Auth::instance()->get_user();
        Site::ini();

		if ($this->request->is_ajax())
		{
			if ( ! $this->auth_user OR ! $this->auth_user->roles->has('admin'))
			{
				$this->error(403);
			}
		}
		else
		{
			if ( ! $this->auth_user)
			{
				if ($this->request->controller() != 'layout' OR $this->request->action() != 'index')
				{
					//print_R($this->request);
                    //$this->request->redirect('admin');
                    //Controller::redirect('admin');
				}
			}
            elseif ( ! $this->auth_user->roles->has('admin'))
			{
				$this->request->redirect('/');
			}

			$this->site = Model::factory('site');
			$this->menu = strtolower(str_replace('Controller_Admin_', '', get_class($this)));

			$this->template = View::factory($this->template);
			$this->template->bind_global('site', $this->site);
			$this->template->bind_global('menu', $this->menu);
			$this->template->bind_global('auth_user', $this->auth_user);
			$this->template->content = NULL;
		}
	}

    public function action_index()
    {
    	if ($this->auth_user)
    	{
    		$this->site->assign(t('admin'));
    		$this->template->content = View::factory('admin/index');
    		return TRUE;
    	}

   		$this->site->assign(t('auth.auth'));
 		$attempt = Session::instance()->get_once('attempt', 1);
		$this->template->content = View::factory('admin/login')->bind('errors', $errors)->set('captcha', $attempt > 2);

        if (HTTP_Request::POST == $this->request->method())
        {
       		if ($attempt > 3 AND ! Captcha::valid($this->request->post('captcha')))
       		{
       			$errors['_external']['captcha'] = t('captcha.Captcha::valid');
       		}
       		else
       		{
	    	    $remember = array_key_exists('remember', $this->request->post());

    	        if (Auth::login($this->request->post('login'), $this->request->post('password'), $remember))
            	{
					$this->request->redirect('admin');
    	        }
        	    else
            	{
                	$errors['login'] = t('auth.auth.error');
	            }
	    	}
	    	Session::instance()->set('attempt', $attempt + 1);
        }
    }

} // End Controller Admin Layout
