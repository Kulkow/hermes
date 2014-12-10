<?php defined('SYSPATH') or die('No direct script access.');

class Model_Currency extends ORM {

    protected $_table_name = 'currency';
    public function rules()
	{
		return array(
			'code' => array(
				array('not_empty'),
			),
		);
	}
    
    /*
    protected $_belongs_to = array(
    		'image'		=> array(
    			'model'		=> 'image',
    		),
    	);
    */
    public function filters()
	{
		return array(
			'code' 	=> array(
				array('strtoupper'),
			),
		);
	}
    
    public function _default($code = 'USD')
    {
        if($code){
            return ORM::factory('currency', array('code' => $code));    
        }
    }
    
    public function curs($currency = NULL)
    {
        if($currency){
            if(intval($currency) > 0){
                $currency_id = intval($currency);
            }else{
                $currency_id = ORM::factory('currency', array('code' => $currency));
            }
            $curs = ORM::factory('curs', array('currency_id' => $this->id, 'currency_eq_id' => $currency_id));
            if(! $curs->loaded()){
                $curs = ORM::factory('curs', array('currency_id' => $currency_id, 'currency_eq_id' => $this->id));
                if($curs->loaded()){
                    $_value = 1/($curs->value);
                    return round($_value,2);
                }
            }
            return round($curs->value,2);
        }
        return FALSE;
    }
    
    public function render(){
        if($this->loaded()){
            return '<span class="currency '.strtolower($this->code).'">'.$this->code.'</span>';       
        }
    }
    
    public function url($action = 'view')
    {
        return Site::url('/currency/'.$this->id.($action ? '/'.$action : ''));
    }
    
    public function url_admin($action)
	{
		return Site::url('/admin/curs/'.$action.'/'.$this->id);
	}

}