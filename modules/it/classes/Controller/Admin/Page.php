<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Page extends Controller_Admin_Layout
{
	public $tree = NULL;

	public function before()
	{
		parent::before();

		$this->tree = ORM::factory('page')->tree();
		$this->template->bind_global('tree', $this->tree);
	}

	public function action_index()
	{
       $this->template->content = View::factory('admin/page/tree');
	}

	public function action_add()
	{
		if (HTTP_Request::POST == $this->request->method())
		{
			try
			{
				$values = $this->request->post();

				$page = ORM::factory('page');
				$page->values($values)->create();
				$page->content->values($values)->page_id = $page->id;
				$page->content->create();

				//$this->request->redirect('admin/page');
                Controller::redirect('admin/page');
			}
			catch (ORM_Validation_Exception $e)
			{
				$_REQUEST = Arr::merge($_REQUEST, $values);
				$errors = $e->errors('page');
			}
		}
		else
		{
			if ($id = $this->request->param('id'))
			{
	    	    $parent = ORM::factory('page', $id);
	        	if ( ! $parent->loaded())
		        {
		        	throw new HTTP_Exception_404();
	    	    }
            	$_REQUEST['pid'] = $parent->id;
			}
            $_REQUEST['children'] = array();
		}

		$this->template->content = View::factory('admin/page/edit')->bind('errors', $errors);
	}

	public function action_edit()
	{
		$page = ORM::factory('page', $this->request->param('id'));
        if ( ! $page->loaded())
        {
        	throw new HTTP_Exception_404();
		}

		if (HTTP_Request::POST == $this->request->method())
		{
			try
			{
				$values = $this->request->post();

				$page->values($values)->update();
				$page->content->values($values)->update();

				//$this->request->redirect('admin/page');
                Controller::redirect('admin/page');
			}
			catch (ORM_Validation_Exception $e)
			{
				$_REQUEST = Arr::merge($_REQUEST, $values);
				$errors = $e->errors('page');
			}
		}
		else
		{
			$_REQUEST = Arr::merge($_REQUEST, $page->as_array(), $page->content->as_array());
			if ($parent = $page->parent())
			{
				$_REQUEST['pid'] = $parent->id;
			}
			$_REQUEST['children'] = $page->children(TRUE);
		}

		$this->template->content = View::factory('admin/page/edit')->bind('errors', $errors);
	}

	public function action_delete()
	{
		$page = ORM::factory('page', $this->request->param('id'));
		if ( ! $page->loaded())
		{
			throw new HTTP_Exception_404();
		}

		$page->delete();

		if ($this->request->is_ajax())
		{
			echo json_encode(array('error' => FALSE));
			exit();
		}
		else
		{
			//$this->request->redirect('admin/page');
            Controller::redirect('admin/page');
		}
	}

	public function action_toggle()
	{
		$page = ORM::factory('page', $this->request->param('id'));
		if ( ! $page->loaded())
		{
			throw new HTTP_Exception_404();
		}

		$page->hide = ! $page->hide;
		$page->update();

		if ($this->request->is_ajax())
		{
			echo json_encode(array('hide' => $page->hide ? 1 : 0));
			exit();
		}
		else
		{
			//$this->request->redirect('admin/page');
            Controller::redirect('admin/page');
		}
	}
}