<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Banner extends Controller_Admin_Layout
{

    
    public function action_index()
	{
		
        if ($total = ORM::factory('banner')->count_all())
		{
			$per_page = 10;
            $page = $this->request->param('page', 1);
			$paging = Paging::make($total, $page, 10, 4, 'admin/user');
			$banners = ORM::factory('banner')->order_by('id', 'desc')
				->offset(($page - 1) * $per_page)->limit($per_page)->find_all();
            
     
    	}
                                 
		$this->template->content = View::factory('admin/banner/list')->bind('banners', $banners)->bind('paging', $paging);
	}
    
    
    
    public function action_add()
	{
		if (HTTP_Request::POST == $this->request->method())
		{
        
            $banner = ORM::factory('banner');
            $values = $this->request->post();
            try
            {
                $banner->values($values);
                $image = ORM::factory('image');
                $image->upload($banner);
                $banner->image = $image;
                $banner->create();
                Controller::redirect('admin/banner');
            }
            catch (ORM_Validation_Exception $e)
            {
                $_REQUEST = Arr::merge($_REQUEST, $values);
    			$errors = $e->errors('banner');
            }
            
               
        }
        
        $this->template->content = View::factory('admin/banner/edit')->bind('errors', $errors);
     }
     
    
     
    public function action_edit()
	{
		$banner = ORM::factory('banner', $this->request->param('id'));
        if ( ! $banner->loaded())
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
                if(! Arr::get($values, 'image', NULL))
                {
                  unset($values['image']);
                  $banner->values($values);  
                }
                else
                {
                  $banner->values($values);
                  $image = ORM::factory('image');
                  $image->upload($banner);
                  $banner->image = $image;    
                }
                
                $banner->save();
                Controller::redirect('admin/banner');
            }
            catch (ORM_Validation_Exception $e)
            {
    			$errors = $e->errors('banner');
            }
        }
        $_REQUEST = Arr::merge($_REQUEST, $banner->as_array());
        $this->template->content = View::factory('admin/banner/edit')->bind('errors', $errors);
    }
    
    
    public function action_delete()
	{
		$banner = ORM::factory('banner', $this->request->param('id'));
        if ( ! $banner->loaded())
        {
        	throw new HTTP_Exception_404();
		}
        $banner->delete();
        Controller::redirect('admin/banner');
     }   
 }       