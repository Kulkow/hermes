<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Curs extends Controller_Admin_Layout
{

    public function action_index()
	{
		
        if ($total = ORM::factory('currency')->count_all())
		{
			$per_page = 10;
            $page = $this->request->param('page', 1);
			$paging = Paging::make($total, $page, 10, 4, 'admin/currency');
			$currencys = ORM::factory('currency')->order_by('code', 'desc')
				->offset(($page - 1) * $per_page)->limit($per_page)->find_all();
    	}
		$this->template->content = View::factory('admin/currency/list')->bind('currencys', $currencys)->bind('paging', $paging);
	}
    
    public function action_curs()
	{
		
        if ($total = ORM::factory('curs')->count_all())
		{
			$per_page = 10;
            $page = $this->request->param('page', 1);
			$paging = Paging::make($total, $page, 10, 4, 'admin/currency/curs');
			$curses = ORM::factory('curs')->order_by('id', 'desc')
				->offset(($page - 1) * $per_page)->limit($per_page)->find_all();
    	}
		$this->template->content = View::factory('admin/currency/curs/list')->bind('curses', $curses)->bind('paging', $paging);
	}
    
    public function action_add()
	{
		if (HTTP_Request::POST == $this->request->method())
		{
            $currency = ORM::factory('currency');
            $values = $this->request->post();
            try
            {
                $currency->values($values);
                $currency->create();
                Controller::redirect('admin/curs');
            }
            catch (ORM_Validation_Exception $e)
            {
                $_REQUEST = Arr::merge($_REQUEST, $values);
    			$errors = $e->errors('currency');
            }
        }
        $this->template->content = View::factory('admin/currency/edit')->bind('errors', $errors);
     }
     
     
    public function action_edit()
	{
		$currency = ORM::factory('currency', $this->request->param('id'));
        if ( ! $currency->loaded())
        {
        	throw new HTTP_Exception_404();
		}
        if (HTTP_Request::POST == $this->request->method())
		{
        
            $values = $this->request->post();
            try
            {
                $currency->values($values);
                $currency->save();
                Controller::redirect('admin/curs');
            }
            catch (ORM_Validation_Exception $e)
            {
    			$errors = $e->errors('currency');
            }
        }
        $_REQUEST = Arr::merge($_REQUEST, $currency->as_array());
        $this->template->content = View::factory('admin/currency/edit')->bind('errors', $errors);
    }
    
    
    public function action_delete()
	{
		$currency = ORM::factory('currency', $this->request->param('id'));
        if ( ! $currency->loaded())
        {
        	throw new HTTP_Exception_404();
		}
        $currency->delete();
        Controller::redirect('admin/curs');
     }
     
     public function action_curs_add()
	{
		if (HTTP_Request::POST == $this->request->method())
		{
            $curs = ORM::factory('curs');
            $values = $this->request->post();
            try
            {
                $curs->values($values);
                $curs->create();
                Controller::redirect('admin/curs/curs');
            }
            catch (ORM_Validation_Exception $e)
            {
                $_REQUEST = Arr::merge($_REQUEST, $values);
    			$errors = $e->errors('curs');
            }
        }
        $this->template->content = View::factory('admin/currency/curs/edit')->bind('errors', $errors);
     }
     
     
    public function action_curs_edit()
	{
		$curs = ORM::factory('curs', $this->request->param('id'));
        if ( ! $curs->loaded()){
        	throw new HTTP_Exception_404();
		}
        if (HTTP_Request::POST == $this->request->method())
		{
            $values = $this->request->post();
            try
            {
                $curs->values($values);
                $curs->save();
                Controller::redirect('admin/curs/curs');
            }
            catch (ORM_Validation_Exception $e)
            {
    			$errors = $e->errors('curs');
            }
        }
        $_REQUEST = Arr::merge($_REQUEST, $curs->as_array());
        $this->template->content = View::factory('admin/currency/curs/edit')->bind('errors', $errors);
    }
    
    
    public function action_curs_delete()
	{
		$curs = ORM::factory('curs', $this->request->param('id'));
        if ( ! $curs->loaded())
        {
        	throw new HTTP_Exception_404();
		}
        $curs->delete();
        Controller::redirect('admin/curs/curs');
     }      
 }       