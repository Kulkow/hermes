<?php defined('SYSPATH') or die('No direct script access.');

class Model_Bill extends ORM {

    protected $_table_name = 'bills';
    public static $default_currency = 'USD';
    public static $allow_currency = array('USD', 'EUR');
    //public static $min_summa = 0.01;
    public static $min_summa = 50;

    protected $_belongs_to = array(
    		'card'		=> array(
    			'model'		=> 'card',
    		),
            'currency'		=> array(
    			'model'		=> 'currency',
    		),
    	);
        
    public function rules()
	{
		return array(
            'summa' => array(
				array('not_empty'),
				array(array($this, 'allow'), array($this,':value')),
			),
            /*
            'percent' => array(
				array('max_length', array(':value', 32)),
				array(array($this, 'unique'), array('code', ':value')),
			),
            */
		);
	}
    
    public function filters()
	{
		return array(
			'status' 	=> array(
				array('intval'),
			),
            'summa' 	=> array(
                array(array($this, 'format'), array(':value')),
			),
            /*'currency' 	=> array(
                array(array($this, 'currency'), array(':value')),
			),*/
            /*
            'active_time' 	=> array(
				array('strtotime'),
			),*/
		);
	}
    
    public function url_admin($action)
	{
		return Site::url('/admin/bill/'.$action.'/'.$this->id);
	}
    
    public static function format($summa = NULL){
        return number_format($summa, 2, '.', '');
    }
    
    public function default_currency(){
        if(! $this->loaded()){
            $default = ORM::factory('currency')->_default();
            if($default->loaded()){
                return $default;    
            }
            
        }
    }
    
    public static function currency($currency = NULL){
        $_currency = self::$default_currency;
        if(in_array($currency,self::$allow_currency)){
            $_currency = $currency;
        }
        return $_currency;
    }
    
    public static function allow($bill,$summa = NULL){
       return  $summa >= self::$min_summa;
    }
    
    public function check_exists($type = NULL, $card = NULL){
        if($card instanceof ORM){
          if(! $card->loaded()){
            return false;
          }  
        }else{
            $card = ORM::factory('card', intval($card));
        }
        $bill = ORM::factory('bill', array('card_id' => $card->id, 'type' => $type, 'status' => 0));
        if($bill->loaded()){
            return $bill;
        }
        return FALSE;
    }
}
 