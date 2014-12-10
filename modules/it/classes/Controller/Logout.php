<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Logout extends Controller
{
	public function action_index()
	{
        if (Auth::instance()->logged_in())
		{
			Auth::instance()->logout(TRUE, TRUE);
		}
        Controller::redirect('/');
	}
}