<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Page extends Model_Tree
{
	protected $_has_one = array('content' => array('model' => 'Page_Content'));

	public function rules()
	{
		return array(
			'title' => array(
				array('not_empty'),
				array('min_length', array(':value', 2)),
				array('max_length', array(':value', 70)),
				array(array($this, 'unique'), array('title', ':value')),
			),
			'alias' => array(
				array('not_empty'),
				array('min_length', array(':value', 2)),
				array('max_length', array(':value', 100)),
				array(array($this, 'unique'), array('alias', ':value')),
			),
		);
	}

	public function values(array $values, array $expected = NULL)
	{
		$values['hide'] = array_key_exists('hide', $values) ? 0 : 1;
		if (empty($values['title']))
		{
			$values['title'] = Text::limit_chars($values['h1'], 70, '', TRUE);
		}
		if (empty($values['alias']))
		{
			$values['alias'] = strtolower(Text::translit($values['title']));
		}
		return parent::values($values, $expected);
	}

	public function block($params)
	{
		if ($alias = $params['alias'])
		{
			$parent = $this->where('alias', '=', $alias)->find();
		}
		if ( ! $view = $params['view'])
		{
			$view = 'block';
		}
		$tree = $this->tree();
		return View::factory('page/'.$view)->bind('tree', $tree)->bind('parent', $parent);
	}

	public function url_admin($action)
	{
		return '/admin/page/'.$action.'/'.$this->id;
	}

	public function url()
	{
		return '/'.$this->alias.'.html';
	}
}