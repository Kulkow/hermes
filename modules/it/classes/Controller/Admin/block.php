<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Block extends Controller_Admin_Layout
{	public function action_index()
	{		$blocks = Block::get();
		$this->template->content = View::factory('admin/block/view')->bind('blocks', $blocks);
	}

	public function action_add()
	{		if (HTTP_Request::POST == $this->request->method())
		{			try
			{				$block = ORM::factory('block')->values($this->request->post())->create();

				$this->request->redirect('admin/block/edit/'.$block->id);
			}
			catch (ORM_Validation_Exception $e)
			{				$errors = $e->errors('block');			}		}
		else
		{			if ($group = $this->request->param('id'))
			{
				if ( ! in_array($group, Block::groups()))
				{
					$_REQUEST['group-new'] = $group;
				}
				$_REQUEST['group'] = $group;
			}
		}
		$this->template->content = View::factory('admin/block/add')->bind('errors', $errors);
	}

	public function action_edit()
	{		$block = ORM::factory('block', $this->request->param('id'));
        if ( ! $block->loaded())
        {
        	$this->error(404);
		}

		if (HTTP_Request::POST == $this->request->method())
		{
			try
			{				$block->values($this->request->post())->update();

				$this->request->redirect('admin/block');
			}
			catch (ORM_Validation_Exception $e)
			{
				$errors = $e->errors($block->errors_filename());
			}
		}
		else
		{			$_REQUEST = Arr::merge($_REQUEST, $block->as_array());
		}
		$this->template->content = View::factory('admin/block/edit')->bind('block', $block)->bind('errors', $errors);
	}

	public function action_delete()
	{		$block = ORM::factory('block', $this->request->param('id'));
		if ( ! $block->loaded())
		{
			$this->error(404);
		}

		$block->delete();

		$this->alert('block.delete.ok');
	}

	public function action_toggle()
	{		$block = ORM::factory('block', $this->request->param('id'));
		if ( ! $block->loaded())
		{			$this->error(404);
		}

		$block->hide = ! $block->hide;
		$block->update();

		$this->response(array('hide' => $block->hide ? 0 : 1), 'admin/block');
	}

	public function action_order()
	{		if (HTTP_Request::POST == $this->request->method())
		{			ORM::factory('block')->order_update($this->request->post('data'));
		}		$this->response(array('error' => FALSE), 'admin/block');
	}

} // End Controller Admin Block