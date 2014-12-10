<?php defined('SYSPATH') or die('No direct script access.');

class Model_Curs extends ORM {

    protected $_table_name = 'currency_curs';
    public function rules()
	{
		return array(
			'value' => array(
				array('not_empty'),
                array(array($this, 'allow'), array($this,':value')),
                //array('decimal'),
			),
		);
	}
    public function filters()
	{
		return array(
            'value' 	=> array(
                array(array($this, 'format'), array(':value')),
			),
		);
	}
    
    public static function format($summa = NULL){
        $summa = (double)($summa);
        return number_format($summa, 2, '.', '');
    }
    
    
    protected $_belongs_to = array(
    		'currency'		=> array(
    			'model'		=> 'currency',
                'foreign_key' => 'currency_id',
    		),
            'currency_eq'		=> array(
    			'model'		=> 'currency',
                'foreign_key' => 'currency_eq_id',
    		),
    	);

    public function allow($object,$value){
        if($object instanceof ORM){
            $currency_id = $currency_eq_id = NULL;
            if($object->currency->loaded()){
                $currency_id = $object->currency->id;
            }
            if($object->currency_eq->loaded()){
                $currency_eq_id = $object->currency_eq->id;
            }
            if($currency_eq_id == $currency_id){
                return FALSE;
            }
            if(! $currency_eq_id){
                return FALSE;
            }
            if(! $currency_id){
                return FALSE;
            }
  
        }
        if($value <= 0){
            return FALSE;
        }
        return TRUE;
    }
    /*public function filters()
	{
		return array(
			'code' 	=> array(
				array('strtoupper'),
			),
		);
	}*/
    
    public function url($action = 'view')
    {
        return Site::url('/currency/'.$this->id.($action ? '/'.$action : ''));
    }
    
    public function url_admin($action = NULL)
	{
		return Site::url('/admin/curs/'.($action ? 'curs_'.$action : '').'/'.$this->id);
	}

}