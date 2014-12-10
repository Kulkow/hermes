<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Stoplist extends ORM {
    
	protected $_table_name = 'stop_list';
    
    public function url_admin($action)
	{
		return Site::url('/admin/stoplist/'.$action.'/'.$this->id);
	}
    
    
    public function rules()
	{
		return array(
			'expires' => array(
				array('not_empty'),
				//array(array($this, 'expires'), array('expires', ':value')),
                array(array($this, 'expires')),
			),
			'ip' => array(
				array('not_empty'),
			),
		);
	}
    
    public function filters()
	{
		return array(
            'expires' 	=> array(
				//array('strtotime'),
                array(array($this, '_strtotime')),
			),
		);
	}
    
    public static function expires($expires)
    {
        if(! is_integer($expires))
        {
            $expires = strtotime($expires);
        }
        return ($expires > time());
    }
    
    public static function _strtotime($time = NULL)
    {
        if(! is_integer($time))
        {
            return strtotime($time);
        }
        return $time;
    }
    
}