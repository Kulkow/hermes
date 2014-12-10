<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Card extends Controller_Admin_Layout
{

	public function before()
	{
		parent::before();

	}

	public function action_index()
	{
       if ($total = ORM::factory('card')->count_all())
		{
			$per_page = 20;
            $page = $this->request->param('page', 1);
			$paging = Paging::make($total, $page, $per_page, 4, 'admin/card');
			$cards = ORM::factory('card')->order_by('created', 'desc')
				->offset(($page - 1) * $per_page)->limit($per_page)->find_all();
                
    	}
        
        $filters = Model_Filter::instance('card', array('filters' => array('id', 'created', 'active'),
                                          'orders' => array('id', 'created', 'active'))
                                          );
                                 
		$this->template->content = View::factory('admin/card/list')->bind('cards', $cards)->bind('paging', $paging);
	}

	public function action_add()
	{
		
       Controller::redirect('admin/user/add');

	}

	public function action_edit()
	{
		$card = ORM::factory('card', $this->request->param('id'));
        if ( ! $card->loaded())
        {
        	throw new HTTP_Exception_404();
		}

		if (HTTP_Request::POST == $this->request->method())
		{
			$percent = $card->percent;
            $ball = $card->ball; 
            try
			{
				$values = $this->request->post();
				$_ball = Arr::get($values,'ball', NULL);
                $_currency = Arr::get($values,'currency_id', NULL);
                unset($values['ball']);
                unset($values['currency_id']);
                $card->values($values);
                if(Arr::get($values,'calc_tarif', NULL)){
                    $card->calc_tarif();
                }
                if(Arr::get($values,'activation', NULL)){
                    $card->activation();
                }
                
                $_percent = Arr::get($values,'percent', NULL);
                
                $card->calc($_ball, $_currency, FALSE, NULL);
                
                $card->update();
				
                Controller::redirect('admin/card');
			}
			catch (ORM_Validation_Exception $e)
			{
				$_REQUEST = Arr::merge($_REQUEST, $values);
				$errors = $e->errors('card');
			}
		}
		else
		{
			$_REQUEST = Arr::merge($_REQUEST, $card->as_array());
		}

		$this->template->content = View::factory('admin/card/edit')->bind('errors', $errors);
	}

	public function action_delete()
	{
		$card = ORM::factory('card', $this->request->param('id'));
		if ( ! $card->loaded()){
			throw new HTTP_Exception_404();
		}
		$card->delete();
		if ($this->request->is_ajax()){
			echo json_encode(array('error' => FALSE));
			exit();
		}
		else
		{
			//$this->request->redirect('admin/page');
            Controller::redirect('admin/card');
		}
	}

	public function action_toggle()
	{
		$card = ORM::factory('card', $this->request->param('id'));
		if ( ! $card->loaded())
		{
			throw new HTTP_Exception_404();
		}

		$card->active = ! $card->active;
		$card->update();

		if ($this->request->is_ajax())
		{
			echo json_encode(array('hide' => $card->active ? 1 : 0));
			exit();
		}
		else
		{
			//$this->request->redirect('admin/page');
            Controller::redirect('admin/card');
		}
	}
}