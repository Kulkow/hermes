<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Blacklist extends Controller_Admin_Layout
{

    public $sort = 'created';
    public $up = 'desc';
    
    
    public function action_index()
	{
		if ($total = ORM::factory('blacklist')->count_all())
		{
			$per_page = 12;
            $page = $this->request->param('page', 1);
			$paging = Paging::make($total, $page, 10, 4, 'admin/stoplist');
			$blacklist = ORM::factory('blacklist')->order_by('ip', 'desc')
				->offset(($page - 1) * $per_page)->limit($per_page)->find_all();
    	}
        
		$this->template->content = View::factory('admin/blacklist/index')->bind('blacklist', $blacklist)->bind('paging', $paging);
	}
    
    
    public static function sort()
    {
        
    }
    
    
    public static function search()
    {
        
    }
    public function action_add()
	{
		if (HTTP_Request::POST == $this->request->method())
		{
        
            $blacklist = ORM::factory('blacklist');
            $values = $this->request->post();
            try
            {
                $blacklist->values($values);
                $blacklist->created = time();
                $blacklist->create();
                ORM::factory('log')->add_action($this->auth_user, 'add', $blacklist);
                Controller::redirect('admin/blacklist');
            }
            catch (ORM_Validation_Exception $e)
            {
                $_REQUEST = Arr::merge($_REQUEST, $values);
    			$errors = $e->errors('blacklist');
            }
        }
        
        $this->template->content = View::factory('admin/blacklist/edit')->bind('errors', $errors);
     }
     public function action_edit()
	 {
		$blacklist = ORM::factory('blacklist',intval($this->request->param('id')));
        if(! $blacklist->loaded())
        {
            throw new HTTP_Exception_404();
        }
        if (HTTP_Request::POST == $this->request->method())
		{
        
            $values = $this->request->post();
            try
            {
                $blacklist->values($values);
                $blacklist->created = time();
                $blacklist->update();
                ORM::factory('log')->add_action($this->auth_user, 'edit', $blacklist);
                Controller::redirect('admin/blacklist');
            }
            catch (ORM_Validation_Exception $e)
            {
    			$errors = $e->errors('blacklist');
            }
            
               
        }
         $_REQUEST = Arr::merge($_REQUEST, $blacklist->as_array());
        $this->template->content = View::factory('admin/blacklist/edit')->bind('errors', $errors);
     }
     
     public function action_delete()
	 {
		$blacklist = ORM::factory('blacklist',intval($this->request->param('id')));
        if(! $blacklist->loaded())
        {
            throw new HTTP_Exception_404();
        }
        ORM::factory('log')->add_action($this->auth_user, 'delete', $blacklist);
        $blacklist->delete();
        Controller::redirect('admin/blacklist');
      }        
 }  