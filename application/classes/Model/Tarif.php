<?php defined('SYSPATH') or die('No direct script access.');

class Model_Tarif extends ORM {

    
    public function rules()
	{
		return array(
			'h1' => array(
				array('not_empty'),
            ),
            'title' => array(
				array('not_empty'),
				array('min_length', array(':value', 2)),
				array('max_length', array(':value', 70)),
				array(array($this, 'unique'), array('title', ':value')),
			),
			'code' => array(
				array('not_empty'),
				array('min_length', array(':value', 2)),
				array('max_length', array(':value', 100)),
				array(array($this, 'unique'), array('code', ':value')),
			),
            'content' => array(
				array('not_empty'),
				array('min_length', array(':value', 5)),
			),
            'from_value' => array(
				array('not_empty'),
			),
			'to_value' => array(
				array('not_empty'),
			),
            'percent' => array(
				array('not_empty'),
            ),
            'frost' => array(
				array('not_empty'),
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
        
		if (empty($values['code']))
		{
			$values['code'] = strtolower(Text::translit($values['title']));
		}
		return parent::values($values, $expected);
	}
   
    
    protected $_belongs_to = array(
    		'to_currency'		=> array(
    			'model'		=> 'currency',
                'foreign_key' => 'to_currency_id',
    		),
            'from_currency'		=> array(
    			'model'		=> 'currency',
                'foreign_key' => 'from_currency_id',
    		),
    	);
    
    public function url($action = 'view')
    {
        return Site::url('/tarif/'.$this->id.($action ? '/'.$action : ''));
    }
    
    public function url_admin($action)
	{
		return Site::url('/admin/tarif/'.$action.'/'.$this->id);
	}
    
    public function render($type = NULL){
        if($this->loaded()){
            $str = '';
            if(! $type){
               $str .= '<div class="from">'. $this->from_value.' <span class="currency '.strtolower($this->from_currency->code).'">'.$this->from_currency->code.'</span></div>';
               $str .= '<div class="to">'. $this->to_value.' <span class="currency '.strtolower($this->to_currency->code).'">'.$this->to_currency->code.'</span></div>';
            }else{
                if($type == 'from'){
                    $str .= '<div class="from">'. $this->from_value.' <span class="currency '.strtolower($this->from_currency->code).'">'.$this->from_currency->code.'</span></div>';
                }else{
                    $str .= '<div class="to">'. $this->to_value.' <span class="currency '.strtolower($this->to_currency->code).'">'.$this->to_currency->code.'</span></div>';
                }
            }
            return $view = '<div class="tarif">'.$str.'</div>';
        }
        return NULL;
    }

}