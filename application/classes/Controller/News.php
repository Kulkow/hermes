<?php defined('SYSPATH') or die('No direct script access.');

class Controller_News extends Controller_Layout
{
	
    public function action_index()
	{
        if ($total = ORM::factory('news')->count_all())
		{
			$per_page = 10;
            $page = $this->request->param('page', 1);
			$paging = Paging::make($total, $page, $per_page, 4, 'news');
			$news = ORM::factory('news')->order_by('created', 'desc')
				->offset(($page - 1) * $per_page)->limit($per_page)->find_all();
    	}
        Menu::$current = 'news';
		$this->template->content = View::factory('news/list')->bind('news', $news)->bind('paging', $paging);
	}
    public function action_view()
	{
		$new = ORM::factory('news', $this->request->param('id'));
		if ( ! $new->loaded() OR $new->hide)
		{
			throw new HTTP_Exception_404();
		}
		$this->template->content = View::factory('news/view')->bind('new', $new);
		Menu::$current = 'menu';
		$this->site->assign($new->title, $new->keywords, $new->description);
	}
}