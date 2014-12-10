<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Menu extends Controller_Admin_Layout
{
	public function action_index()
	{
		$this->template->content = View::factory('admin/menu/view');
	}

	public function action_add()
	{
		if (HTTP_Request::POST == $this->request->method())
		{
			try
			{
				$menu = ORM::factory('menu');
				$menu->values($this->request->post())->create();

				//$this->request->redirect('admin/menu');
                Controller::Redirect('admin/menu');
			}
			catch (ORM_Validation_Exception $e)
			{
				$errors = $e->errors('menu');
			}
		}
		else
		{
			if ($group = $this->request->param('id'))
			{
				if ( ! in_array($group, Menu::groups()))
				{
					$_REQUEST['group-new'] = $group;
				}
				$_REQUEST['group'] = $group;
			}
		}
		$this->template->content = View::factory('admin/menu/edit')->bind('errors', $errors);
	}

	public function action_edit()
	{
		$menu = ORM::factory('menu', $this->request->param('id'));
        if ( ! $menu->loaded())
        {
        	$this->error(404);
		}

		if (HTTP_Request::POST == $this->request->method())
		{
			try
			{
				$menu->values($this->request->post())->update();

				//$this->request->redirect('admin/menu');
                Controller::Redirect('admin/menu');
			}
			catch (ORM_Validation_Exception $e)
			{
				$errors = $e->errors('menu');
			}
		}
		else
		{
			$_REQUEST = Arr::merge($_REQUEST, $menu->as_array());
		}
		$this->template->content = View::factory('admin/menu/edit')->bind('errors', $errors);
	}

	public function action_delete()
	{
		$menu = ORM::factory('menu', $this->request->param('id'));
		if ( ! $menu->loaded())
		{
			$this->error(404);
		}

		$menu->delete();

		$this->alert('menu.delete.ok', 'admin/menu');
	}

	public function action_toggle()
	{
		$menu = ORM::factory('menu', $this->request->param('id'));
		if ( ! $menu->loaded())
		{
			$this->error(404);
		}

		$menu->hide = ! $menu->hide;
		$menu->update();

		$this->response(array('hide' => $menu->hide ? 0 : 1), 'admin/menu');
	}

	public function action_order()
	{
		if (HTTP_Request::POST == $this->request->method())
		{
			ORM::factory('menu')->order_update($this->request->post('data'));
		}
		$this->response(array('error' => FALSE), 'admin/menu');
	}

} // End Controller Admin Menu