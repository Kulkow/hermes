<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Tarif extends Controller_Layout
{
	
    public function action_index()
	{
        if ($total = ORM::factory('tarif')->count_all())
		{
			$per_page = 10;
            $page = $this->request->param('page', 1);
			$paging = Paging::make($total, $page, $per_page, 4, 'tarif'); 
			$tarifs = ORM::factory('tarif')->order_by('created', 'desc')
				->offset(($page - 1) * $per_page)->limit($per_page)->find_all();
    	}
        Menu::$current = '/';
		$this->template->content = View::factory('tarif/list')->bind('tarifs', $tarifs)->bind('paging', $paging);
	}
    public function action_view()
	{
		$tarif = ORM::factory('tarif', $this->request->param('id'));
		if ( ! $tarif->loaded())
		{
			throw new HTTP_Exception_404();
		}
		$this->template->content = View::factory('tarif/view')->bind('tarif', $tarif);
		Menu::$current = 'menu';
		$this->site->assign($tarif->title, $tarif->keywords, $tarif->description);
	}
}