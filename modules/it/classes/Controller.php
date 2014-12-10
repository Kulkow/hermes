<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller extends Kohana_Controller
{
	public $auth_user = FALSE;

	public function before()
	{
        if (HTTP_Request::POST == $this->request->method() AND ! Security::check($this->request->post('token')))
		{
			$this->error('csrf');
		}
	}

	public function after()
    {
    	if ( ! $this->request->is_ajax())
    	{
			if (Kohana::$environment == Kohana::DEVELOPMENT)
			{

				if ($this->request->is_initial())
				{
					$body = $this->template->render();
                    //$body = $this->template->render().View::factory('profiler/stats');
				}
				else
				{
					$body = $this->template->content->render();
				}
				
				$this->response->body($body);
                
			}
			else
			{
		   		$this->response->body(preg_replace('/(\s+)\s{1,}/u', "\n", $this->template->render()));
		   	}
    	}
    }

	public function internal($uri, array $post = array())
	{
		$post['auth_user'] = $this->auth_user ? $this->auth_user->login : FALSE;
		$post['token'] = Security::token();

		$request = Request::factory('internal/'.$uri);
		$request->method(HTTP_Request::POST);
		$request->post(array_merge($post, $this->request->post()));

		return $request->execute();
	}


	public function error($error, $referer = NULL)
	{
		Site::ini();
        if ($this->request->is_ajax())
		{
			$this->json(array('error' => t((is_numeric($error) OR $error == 'csrf') ? 'error.'.$error : $error)));
		}

		if ($error == 'csrf')
		{
			exit(Request::factory('error/csrf')->execute());
		}

		if (is_numeric($error))
		{
			$class = 'HTTP_Exception_'.$error;
			throw new $class();
		}

		Message::error(t($error));

		if ($referer !== FALSE)
		{
			//$this->request->redirect($referer ? $referer : Arr::get($_SERVER, 'HTTP_REFERER'));
            Controller::redirect($referer ? $referer : Arr::get($_SERVER, 'HTTP_REFERER'));
		}
	}
    
    public function response(array $response, $redirect = NULL)
	{
		if ($this->request->is_ajax())
		{
			$this->json($response);
		}

		Controller::redirect($redirect);
	}

	public function alert($alert, $referer = NULL)
	{
		if ($this->request->is_ajax())
		{
			$this->json(array('alert' => t($alert)));
		}

		Message::notice(t($alert));

		Controller::redirect($referer ? $referer : Arr::get($_SERVER, 'HTTP_REFERER'));
	}

	public function json(array $array)
	{
		exit(json_encode($array));
	}

} // End Controller
