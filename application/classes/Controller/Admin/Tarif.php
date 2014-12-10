<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Tarif extends Controller_Admin_Layout
{

    public function action_index()
	{
		
        if ($total = ORM::factory('tarif')->count_all())
		{
			$per_page = 10;
            $page = $this->request->param('page', 1);
			$paging = Paging::make($total, $page, $per_page, 4, 'admin/tarif');
			$tarifs = ORM::factory('tarif')->order_by('created', 'desc')
				->offset(($page - 1) * $per_page)->limit($per_page)->find_all();
    	}
		$this->template->content = View::factory('admin/tarif/list')->bind('tarifs', $tarifs)->bind('paging', $paging);
	}
    
    public function action_add()
	{
		if (HTTP_Request::POST == $this->request->method())
		{
            $tarif = ORM::factory('tarif');
            $values = $this->request->post();
            try
            {
                $tarif->values($values);
                /*$validation = Validation::factory($_FILES)->rules('image', array(
                	array('Upload::valid'),
                	array('Upload::not_empty'),
                ));
        		if ($validation->check()){
        		    $image = ORM::factory('image');
                    $image->upload($news);
                    $news->image = $image;    
        		}*/
                $tarif->created = time();
                $tarif->create();
                Controller::redirect('admin/tarif');
            }
            catch (ORM_Validation_Exception $e)
            {
                $_REQUEST = Arr::merge($_REQUEST, $values);
    			$errors = $e->errors('tarif');
            }
        }
        $this->template->content = View::factory('admin/tarif/edit')->bind('errors', $errors);
     }
     
     
    public function action_edit()
	{
		$tarif = ORM::factory('tarif', $this->request->param('id'));
        if ( ! $tarif->loaded())
        {
        	throw new HTTP_Exception_404();
		}
        if (HTTP_Request::POST == $this->request->method())
		{
        
            $values = $this->request->post();
            try
            {
                $tarif->values($values);
                $tarif->save();
                Controller::redirect('admin/tarif');
            }
            catch (ORM_Validation_Exception $e)
            {
    			$errors = $e->errors('tarif');
            }
        }
        $_REQUEST = Arr::merge($_REQUEST, $tarif->as_array());
        $this->template->content = View::factory('admin/tarif/edit')->bind('errors', $errors);
    }
    
    
    public function action_delete()
	{
		$tarif = ORM::factory('tarif', $this->request->param('id'));
        if ( ! $tarif->loaded())
        {
        	throw new HTTP_Exception_404();
		}
        $tarif->delete();
        Controller::redirect('admin/tarif');
     }   
 }       