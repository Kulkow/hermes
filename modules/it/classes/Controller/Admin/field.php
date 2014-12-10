<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Field extends Controller_Admin_Layout
{	public $form = NULL;

	public function before()
	{		parent::before();

		$this->form = ORM::factory($this->request->query('form'), $this->request->query('id'));
		if ( ! $this->form->loaded())
		{        	$this->error(404);
		}

		if ( ! $this->request->is_ajax())
		{
			$this->template->bind_global('form', $this->form);
			$this->menu = $this->form->object_name();
		}
	}

	public function action_index()
	{		$this->template->content = View::factory('admin/field/view');
	}

	public function action_add()
	{		if (HTTP_Request::POST == $this->request->method())
		{
			try
			{
				$field = ORM::factory('field');
				$field->form = $this->form->object_name();
				$field->form_id = $this->form->id;
				$field->values($this->request->post())->create();

				$this->request->redirect($field->url('edit'));
			}
			catch (ORM_Validation_Exception $e)
			{
				$errors = $e->errors('field');
			}
		}
		$this->template->content = View::factory('admin/field/add')->bind('errors', $errors);
	}

	public function action_edit()
	{
		$field = ORM::factory('field', $this->request->param('id'));
        if ( ! $field->loaded())
        {
        	$this->error(404);
		}

		if (HTTP_Request::POST == $this->request->method())
		{
			try
			{
				$field->values($this->request->post())->update();

				$this->request->redirect('admin/field'.URL::query());
			}
			catch (ORM_Validation_Exception $e)
			{
				$errors = $e->errors('feedback');
			}
		}
		else
		{
			$_REQUEST = Arr::merge($_REQUEST, $field->as_array());
		}
		$this->template->content = View::factory('admin/field/edit')->bind('errors', $errors);
	}

	public function action_delete()
	{
		$field = ORM::factory('field', $this->request->param('id'));
        if ( ! $field->loaded())
        {
        	$this->error(404);
		}

		$field->delete();

		$this->alert('field.delete.ok', 'admin/field'.URL::query());
	}

	public function action_toggle()
	{
		$field = ORM::factory('field', $this->request->param('id'));
        if ( ! $field->loaded())
        {
			$this->error(404);
		}

		$field->hide = ! $field->hide;
		$field->update();

		$this->response(array('hide' => $field->hide ? 0 : 1), 'admin/field'.URL::query());
	}

	public function action_order()
	{
		if (HTTP_Request::POST == $this->request->method())
		{
			ORM::factory('field')->order_update($this->request->post('data'));
		}
		$this->response(array('error' => FALSE), 'admin/field'.URL::query());
	}

} // End Controller Admin Field