<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Slider extends Controller_Admin_Layout
{

    
    public function action_index()
	{
		
        if ($total = ORM::factory('slider')->count_all())
		{
			$per_page = 10;
            $page = $this->request->param('page', 1);
			$paging = Paging::make($total, $page, 10, 4, 'admin/user');
			$sliders = ORM::factory('slider')->order_by('id', 'desc')
				->offset(($page - 1) * $per_page)->limit($per_page)->find_all();
            
     
    	}
                                 
		$this->template->content = View::factory('admin/slider/list')->bind('sliders', $sliders)->bind('paging', $paging);
	}
    
    
    
    public function action_add()
	{
		if (HTTP_Request::POST == $this->request->method())
		{
        
            $slider = ORM::factory('slider');
            $values = $this->request->post();
            try
            {
                $slider->values($values);
                $image = ORM::factory('image');
                $image->upload($slider);
                $slider->image = $image;
                
                $slider->create();
                Controller::redirect('admin/slider');
            }
            catch (ORM_Validation_Exception $e)
            {
                $_REQUEST = Arr::merge($_REQUEST, $values);
    			$errors = $e->errors('slider');
            }
            
               
        }
        
        $this->template->content = View::factory('admin/slider/edit')->bind('errors', $errors);
     }
     
    
     
    public function action_edit()
	{
		$slider = ORM::factory('slider', $this->request->param('id'));
        if ( ! $slider->loaded())
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
                  $slider->values($values);  
                }
                else
                {
                  $slider->values($values);
                  $image = ORM::factory('image');
                  $image->upload($banner);
                  $slider->image = $image;    
                }
                $slider->values($values);

                $slider->save();
                Controller::redirect('admin/slider');
            }
            catch (ORM_Validation_Exception $e)
            {
    			$errors = $e->errors('slider');
            }
        }
        $_REQUEST = Arr::merge($_REQUEST, $slider->as_array());
        $this->template->content = View::factory('admin/slider/edit')->bind('errors', $errors);
    }
    
    
    public function action_delete()
	{
		$slider = ORM::factory('slider', $this->request->param('id'));
        if ( ! $slider->loaded())
        {
        	throw new HTTP_Exception_404();
		}
        $slider->delete();
        Controller::redirect('admin/slider');
     }   
 }       