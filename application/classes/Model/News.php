<?php defined('SYSPATH') or die('No direct script access.');

class Model_News extends ORM {

    protected $_table_name = 'news';
    
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
            'content' => array(
				array('not_empty'),
				array('min_length', array(':value', 5)),
			),
		);
	}
    
    public function values(array $values, array $expected = NULL)
	{
		$values['hide'] = array_key_exists('hide', $values) ? 0 : 1;
		if (empty($values['title']))
		{
			$values['title'] = Text::limit_chars($values['name'], 70, '', TRUE);
		}
        if (empty($values['h1']))
		{
			$values['h1'] = Text::limit_chars($values['title'], 70, '', TRUE);
		}
		if (empty($values['alias']))
		{
			$values['alias'] = strtolower(Text::translit($values['title']));
		}
		return parent::values($values, $expected);
	}
    
    protected $_belongs_to = array(
    		'image'		=> array(
    			'model'		=> 'image',
    		),
    	);
    
    public function url($action = 'view')
    {
        return Site::url('/news/'.$this->id.($action ? '/'.$action : ''));
    }
    
    public function url_admin($action)
	{
		return Site::url('/admin/news/'.$action.'/'.$this->id);
	}

}