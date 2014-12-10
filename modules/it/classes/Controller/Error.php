<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Error extends Controller_Layout
{
	public function action_index()
	{
		$this->template->exception = $this->request->query('status');
	}

	public function action_csrf()
	{
		$this->template->exception = 'csrf';
	}

	public function after()
	{
		//$this->site->seo(strtoupper($this->template->exception));

		if (Kohana::$environment == Kohana::DEVELOPMENT)
		{
			$this->response->body($this->template->render());
		}
		else
		{
	   		$this->response->body(preg_replace('/(\s+)\s{1,}/u', "\n", $this->template->render()));
	   	}

		if (is_numeric($this->template->exception))
		{
			$this->response->status($this->template->exception)->send_headers();
		}
		else
		{
			/**
			 * CSRF - Bad Request
			 */
			$this->response->status(400)->send_headers();
		}
	}

} // End Controller Error