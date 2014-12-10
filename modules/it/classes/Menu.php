<?php defined('SYSPATH') or die('No direct access allowed.');

class Menu
{
	static public function get($group = NULL, $hide = FALSE, $auth = FALSE)
	{
		$menu = ORM::factory('menu')->order_by('group')->order_by('order');
		if ($group !== NULL)
		{
			$menu->where('group', '=', $group);
		}
		if ($hide)
		{
			$menu->and_where('hide', '=', 0);
		}
		if ($auth)
		{
			$menu->and_where('auth', 'in', array(0, Auth::instance()->logged_in() ? 1 : 2));
		}
		return $menu->find_all();
	}

	static public function groups()
	{
		return ORM::factory('menu')->groups();
	}

	static public function render($group)
	{
		$menu = self::get($group, TRUE, TRUE);
		if ( ! $view = Kohana::find_file('views', 'menu/'.$group))
		{
			$view = 'menu/menu';
		}
		return View::factory($view)->bind('menu', $menu)->render();
	}

	static public $current = NULL;

	static public function index()
	{
		return ORM::factory('menu', array('url' => '/'));
	}
}