<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Payment extends Controller_Admin_Layout
{

    public function action_index()
	{
		
        if ($total = ORM::factory('payment')->count_all())
		{
			$per_page = 10;
            $page = $this->request->param('page', 1);
			$paging = Paging::make($total, $page, 10, 4, 'admin/payment');
			$payments = ORM::factory('payment')->order_by('created', 'desc')
				->offset(($page - 1) * $per_page)->limit($per_page)->find_all();
    	}
		$this->template->content = View::factory('admin/payment/list')->bind('payments', $payments)->bind('paging', $paging);
	}
    
    public function action_add()
	{
		if (HTTP_Request::POST == $this->request->method())
		{
            $payment = ORM::factory('payment');
            $values = $this->request->post();
            try
            {
                $payment->values($values);
                $payment->created = time();
                $payment->create();
                Controller::redirect('admin/payment');
            }
            catch (ORM_Validation_Exception $e)
            {
                $_REQUEST = Arr::merge($_REQUEST, $values);
    			$errors = $e->errors('payment');
            }
        }
        $this->template->content = View::factory('admin/payment/edit')->bind('errors', $errors);
     }
     
     
    public function action_edit()
	{
		$payment = ORM::factory('payment', $this->request->param('id'));
        if ( ! $payment->loaded())
        {
        	throw new HTTP_Exception_404();
		}
        if (HTTP_Request::POST == $this->request->method())
		{
        
            $values = $this->request->post();
            try
            {
                $payment->values($values);
                $payment->save();
                Controller::redirect('admin/payment');
            }
            catch (ORM_Validation_Exception $e)
            {
    			$errors = $e->errors('payment');
            }
        }
        $_REQUEST = Arr::merge($_REQUEST, $payment->as_array());
        $this->template->content = View::factory('admin/payment/edit')->bind('errors', $errors);
    }
    
    
    public function action_delete()
	{
		$payment = ORM::factory('payment', $this->request->param('id'));
        if ( ! $news->loaded())
        {
        	throw new HTTP_Exception_404();
		}
        $payment->delete();
        Controller::redirect('admin/payment');
     }   
 }       