<?php defined('SYSPATH') or die('No direct script access.');

class Model_Page_Block_Tree extends Model_Module_Block
{
	public function render(ORM $block)
	{
		$parent = ORM::factory('page', array('alias' => Arr::get($block->data, 'alias')));
		$tree = $parent->tree(FALSE);

		if ( ! $view = $block->view)
		{
			$view = 'tree';
		}

		return View::factory('page/block/'.$view)
			->bind('block', $block)->bind('tree', $tree)
			->set('offset', $parent->loaded() ? $parent->level + 1 : 1)
			->render();
	}
}