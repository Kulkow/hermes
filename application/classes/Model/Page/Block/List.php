<?php defined('SYSPATH') or die('No direct script access.');

class Model_Page_Block_List extends Model_Module_Block
{
	public function render(ORM $block)
	{
		$list = ORM::factory('page', array('alias' => Arr::get($block->data, 'alias')))->tree(FALSE);

		if ( ! $view = $block->view)
		{
			$view = 'list';
		}

		return View::factory('page/block/'.$view)->bind('block', $block)->bind('list', $list)->render();
	}

}