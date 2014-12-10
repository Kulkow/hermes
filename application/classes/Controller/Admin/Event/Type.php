<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Event_Type extends Controller_Admin_Layout
{

	public function before()
	{
		parent::before();

	}

	public function action_index()
	{
       if ($total = ORM::factory('event_type')->count_all())
		{
			$per_page = 12;
            $page = $this->request->param('page', 1);
			$paging = Paging::make($total, $page, $per_page, 4, 'admin/user');
			$event_types = ORM::factory('event_type')->order_by('code', 'asc')
				->offset(($page - 1) * $per_page)->limit($per_page)->find_all();
                
    	}
        
        $filters = Model_Filter::instance('card', array('filters' => array('id', 'created', 'active'),
                                          'orders' => array('id', 'created', 'active'))
                                          );
                                 
		$this->template->content = View::factory('admin/event/type/list')->bind('event_types', $event_types)->bind('paging', $paging);
	}

	public function action_add()
	{
		if (HTTP_Request::POST == $this->request->method())
		{
			try
			{
				$values = $this->request->post();

				$event_type = ORM::factory('event_type');
				$event_type->values($values)->create();

                Controller::redirect('admin/event/type');
			}
			catch (ORM_Validation_Exception $e)
			{
				$_REQUEST = Arr::merge($_REQUEST, $values);
				$errors = $e->errors('event');
			}
		}

		$this->template->content = View::factory('admin/event/type/edit')->bind('errors', $errors);
	}

	public function action_edit()
	{
		$event_type = ORM::factory('event_type', $this->request->param('id'));
        if ( ! $event_type->loaded())
        {
        	throw new HTTP_Exception_404();
		}

		if (HTTP_Request::POST == $this->request->method())
		{
			try
			{
				$values = $this->request->post();

				$event_type->values($values)->update();
				//$this->request->redirect('admin/page');
                Controller::redirect('admin/event/type');
			}
			catch (ORM_Validation_Exception $e)
			{
				$_REQUEST = Arr::merge($_REQUEST, $values);
				$errors = $e->errors('event');
			}
		}
		else
		{
			$_REQUEST = Arr::merge($_REQUEST, $event_type->as_array());
		}

		$this->template->content = View::factory('admin/event/type/edit')->bind('errors', $errors);
	}

	public function action_delete()
	{
		$event_type = ORM::factory('event_type', $this->request->param('id'));
		if ( ! $event_type->loaded())
		{
			throw new HTTP_Exception_404();
		}

		$event_type->delete();

		if ($this->request->is_ajax())
		{
			echo json_encode(array('error' => FALSE));
			exit();
		}
		else
		{
			//$this->request->redirect('admin/page');
            Controller::redirect('admin/event/type');
		}
	}

	/*public function action_toggle()
	{
		$event_type = ORM::factory('event_type', $this->request->param('id'));
		if ( ! $event_type->loaded())
		{
			throw new HTTP_Exception_404();
		}

		$event_type->active = ! $card->active;
		$card->update();

		if ($this->request->is_ajax())
		{
			echo json_encode(array('hide' => $card->active ? 1 : 0));
			exit();
		}
		else
		{
			
            Controller::redirect('admin/card');
		}
	}*/
}