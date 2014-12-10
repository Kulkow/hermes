<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Block extends Controller_Admin_Layout
{
	{
		$this->template->content = View::factory('admin/block/view')->bind('blocks', $blocks);
	}

	public function action_add()
	{
		{
			{

				$this->request->redirect('admin/block/edit/'.$block->id);
			}
			catch (ORM_Validation_Exception $e)
			{
		else
		{
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
	{
        if ( ! $block->loaded())
        {
        	$this->error(404);
		}

		if (HTTP_Request::POST == $this->request->method())
		{
			try
			{

				$this->request->redirect('admin/block');
			}
			catch (ORM_Validation_Exception $e)
			{
				$errors = $e->errors($block->errors_filename());
			}
		}
		else
		{
		}
		$this->template->content = View::factory('admin/block/edit')->bind('block', $block)->bind('errors', $errors);
	}

	public function action_delete()
	{
		if ( ! $block->loaded())
		{
			$this->error(404);
		}

		$block->delete();

		$this->alert('block.delete.ok');
	}

	public function action_toggle()
	{
		if ( ! $block->loaded())
		{
		}

		$block->hide = ! $block->hide;
		$block->update();

		$this->response(array('hide' => $block->hide ? 0 : 1), 'admin/block');
	}

	public function action_order()
	{
		{
		}
	}

} // End Controller Admin Block