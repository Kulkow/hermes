<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_News extends Controller_Admin_Layout
{

    public function action_index()
	{
		
        if ($total = ORM::factory('news')->count_all())
		{
			$per_page = 10;
            $page = $this->request->param('page', 1);
			$paging = Paging::make($total, $page, 10, 4, 'admin/news');
			$news = ORM::factory('news')->order_by('created', 'desc')
				->offset(($page - 1) * $per_page)->limit($per_page)->find_all();
    	}
		$this->template->content = View::factory('admin/news/list')->bind('news', $news)->bind('paging', $paging);
	}
    
    public function action_add()
	{
		if (HTTP_Request::POST == $this->request->method())
		{
            $news = ORM::factory('news');
            $values = $this->request->post();
            try
            {
                $news->values($values);
                $validation = Validation::factory($_FILES)->rules('image', array(
                	array('Upload::valid'),
                	array('Upload::not_empty'),
                ));
        		if ($validation->check()){
        		    $image = ORM::factory('image');
                    $image->upload($news);
                    $news->image = $image;    
        		}
                $news->created = time();
                $news->create();
                Controller::redirect('admin/news');
            }
            catch (ORM_Validation_Exception $e)
            {
                $_REQUEST = Arr::merge($_REQUEST, $values);
    			$errors = $e->errors('news');
            }
        }
        $this->template->content = View::factory('admin/news/edit')->bind('errors', $errors);
     }
     
     
    public function action_edit()
	{
		$news = ORM::factory('news', $this->request->param('id'));
        if ( ! $news->loaded())
        {
        	throw new HTTP_Exception_404();
		}
        if (HTTP_Request::POST == $this->request->method())
		{
        
            $values = $this->request->post();
            try
            {
                if($delete = Arr::get($values, 'delete_image', NULL))
                {
                    ORM::factory('image', intval($delete))->delete();
                }
                 $validation = Validation::factory($_FILES)->rules('image', array(
                    	array('Upload::valid'),
                    	array('Upload::not_empty'),
                    ));
        		 if ($validation->check()){
                  $image = ORM::factory('image');
                  $image->upload($news);
                  $news->image = $image;
                 }    
                $news->values($values);
                $news->save();
                Controller::redirect('admin/news');
            }
            catch (ORM_Validation_Exception $e)
            {
    			$errors = $e->errors('news');
            }
        }
        $_REQUEST = Arr::merge($_REQUEST, $news->as_array());
        $this->template->content = View::factory('admin/news/edit')->bind('errors', $errors);
    }
    
    
    public function action_delete()
	{
		$news = ORM::factory('news', $this->request->param('id'));
        if ( ! $news->loaded())
        {
        	throw new HTTP_Exception_404();
		}
        $news->delete();
        Controller::redirect('admin/news');
     }   
 }       