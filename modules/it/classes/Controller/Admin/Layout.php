<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Layout extends Controller
{
	public $template = NULL;
	public $menu = NULL;
	public $site = NULL;
    

	public function before()
	{
		$auth = Auth::instance();
        Site::ini();
		if ($this->request->is_ajax())
		{
			if ( ! $auth->logged_in('admin'))
			{
				$this->error('error.403.title');
			}
		}
		else
		{
			if ( ! $auth->logged_in())
			{
                $controller = strtolower($this->request->controller());
                if ($controller != 'layout' OR $this->request->action() != 'index')
				{
                    Controller::redirect(Site::url('login'));
                    //Controller::redirect('admin');
				}else{
				    Controller::redirect(Site::url('login'));
				}
			}
            elseif ( ! $auth->logged_in('admin'))
			{
				echo '4';
                //$this->request->redirect();
                Controller::redirect(Site::url('login'));
			}

			$this->site = ORM::factory('site')->find();
			$this->menu = strtolower(str_replace('Controller_Admin_', '', get_class($this)));
			//$modules = Module::get();
			$this->template = View::factory('admin/layout')->bind('menu', $this->menu);
			//$this->template->bind_global('modules', $modules);
			$this->auth_user = $auth->get_user();
            
            $this->template->bind_global('auth_user', $this->auth_user);
            $this->template->bind_global('site', $this->site);
			$this->template->content = NULL;
		}
	}

    public function action_index()
    {
    	if (Auth::instance()->logged_in())
    	{
    		$this->template->content = View::factory('admin/index');
    		return TRUE;
    	}

 		$attempt = Session::instance()->get_once('auth_attempt', 1);
		$this->template->content = View::factory('admin/login')->bind('errors', $errors)->set('captcha', $attempt > 2);

        if (HTTP_Request::POST == $this->request->method())
        {
       		if ($attempt > 3 AND ! Captcha::valid($this->request->post('captcha')))
       		{
       			$errors['captcha'] = t('captcha.Captcha::valid');
       		}
       		else
       		{
	    	    $remember = array_key_exists('remember', $this->request->post());
    	        if (Auth::instance()->login($this->request->post('login'), $this->request->post('password'), $remember))
            	{
					//$this->request->redirect('admin');
                     Controller::redirect('admin');
    	        }
        	    else
            	{
                	$errors['login'] = t('auth.login.error');
	            }
	    	}
	    	Session::instance()->set('auth_attempt', $attempt + 1);
        }
    }

} // End Controller Admin Layout
