<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Menu extends Model_List_Group
{
	protected $_table_name = 'menu';

	public function rules()
	{
		return array(
			'group' => array(
				array('not_empty'),
				array('max_length', array(':value', 100)),
			),
			'title' => array(
				array('not_empty'),
				array('max_length', array(':value', 100)),
			),
			'url' 	=> array(
				array('not_empty'),
				array('max_length', array(':value', 250)),
			),
			'class'	=> array(
				array('max_length', array(':value', 100)),
			),
		);
	}

	public function values(array $values, array $expected = NULL)
	{
		if (empty($values['url']))
		{
			$values['url'] = Text::translit($values['title']);
		}
		return parent::values($values, $expected);
	}

	public function get_css_class($current = 'current')
	{
		$classes = NULL;
		if ($this->class)
		{
			$classes[] = $this->class;
		}
		if ($this->id == Menu::$current)
		{
			$classes[] = $current;
		}
        if ($this->class == Menu::$current)
		{
			$classes[] = $current;
		}
		return $classes === NULL ? '' : ' class="'.implode(' ', $classes).'"';
	}
}