<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Stoplist extends Controller_Admin_Layout
{

    public $sort = 'created';
    public $up = 'desc';
    
    
    public function action_index()
	{
		if ($total = ORM::factory('stoplist')->count_all())
		{
			$per_page = 12;
            $page = $this->request->param('page', 1);
			$paging = Paging::make($total, $page, 10, 4, 'admin/stoplist');
			$stoplist = ORM::factory('stoplist')->order_by('expires', 'desc')
				->offset(($page - 1) * $per_page)->limit($per_page)->find_all();
    	}
        
		$this->template->content = View::factory('admin/stoplist/index')->bind('stoplist', $stoplist)->bind('paging', $paging);
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
        
            $stoplist = ORM::factory('stoplist');
            $values = $this->request->post();
            try
            {
                $stoplist->values($values);
                $stoplist->create();
                ORM::factory('log')->add_action($this->auth_user, 'add', $stoplist);
                Controller::redirect('admin/stoplist');
            }
            catch (ORM_Validation_Exception $e)
            {
                $_REQUEST = Arr::merge($_REQUEST, $values);
    			$errors = $e->errors('stoplist');
            }
            
               
        }
        
        $this->template->content = View::factory('admin/stoplist/edit')->bind('errors', $errors);
     }
     public function action_edit()
	 {
		$stoplist = ORM::factory('stoplist',intval($this->request->param('id')));
        if(! $stoplist->loaded())
        {
            throw new HTTP_Exception_404();
        }
        if (HTTP_Request::POST == $this->request->method())
		{
        
            $values = $this->request->post();
            try
            {
                $stoplist->values($values);
                $stoplist->update();
                ORM::factory('log')->add_action($this->auth_user, 'edit', $stoplist);
                Controller::redirect('admin/stoplist');
            }
            catch (ORM_Validation_Exception $e)
            {
    			$errors = $e->errors('stoplist');
            }
            
               
        }
         $_REQUEST = Arr::merge($_REQUEST, $stoplist->as_array());
        $this->template->content = View::factory('admin/stoplist/edit')->bind('errors', $errors);
     }
     
     public function action_delete()
	 {
		$stoplist = ORM::factory('stoplist',intval($this->request->param('id')));
        if(! $stoplist->loaded())
        {
            throw new HTTP_Exception_404();
        }
        ORM::factory('log')->add_action($this->auth_user, 'delete', $stoplist);
        $stoplist->delete();
        Controller::redirect('admin/stoplist');
      }      
 }  