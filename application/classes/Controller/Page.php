<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Page extends Controller_Layout
{
	public function action_view()
	{
		$page = ORM::factory('page')
			->with('content')
			->where('alias', '=', $this->request->param('alias'))
			->find();

		if ( ! $page->loaded() OR $page->hide)
		{
			throw new HTTP_Exception_404();
		}
		$this->template->content = View::factory('page/view')->bind('page', $page);

		/**
		 * Menu
		 */
		Menu::$current = $page->mid;
       $this->menu = $page->alias;
		/**
		 * SEO
		 */
		$this->site->assign($page->title, $page->content->keywords, $page->content->description);
	}
}