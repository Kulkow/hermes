<?php defined('SYSPATH') or die('No direct script access.');

class Model_Card extends ORM {

    protected $_table_name = 'cards';
    
    public static $out_day = 0; // 0-6 Воскресенье - Суббота
    
    public static $out_days = array(0,6); // 0-6 Воскресенье - Суббота 
    
    
    protected $_belongs_to = array(
    		/**
    		 * Владелец card
    		 */
    		'user'		=> array(
    			'model'		=> 'user',
    		),
            'tarif'		=> array(
    			'model'		=> 'tarif',
    		),
            'currency'		=> array(
    			'model'		=> 'currency',
    		),
    	);
        
    /*protected $_has_many = array(
            'events' => array(
                'through' => 'cards_events'),
    );*/
    
    
    public function rules()
	{
		return array(
			'code' => array(
				array('not_empty'),
				array('max_length', array(':value', 32)),
				array(array($this, 'unique'), array('code', ':value')),
			),
            'percent' => array(
				array('max_length', array(':value', 32)),
			),
		);
	}
    
    public function filters()
	{
		return array(
			/*'code' 	=> array(
				array('strtolower'),
			),*/
            'start_time' 	=> array(
                array(array($this, 'time'), array(':value')),
			),
            'active_time' 	=> array(
                array(array($this, 'time'), array(':value')),
			),
		);
	}
    
    public static function time($value = NULL){
        if(intval($value) > 0){
            return intval($value);
        }else{
            return strtotime($value);
        }
    }
    
    public static function summa_format($value = NULL){
        return number_format($value, 2, '.', '');
    }
    public function _tarif(){
        if($this->loaded()){
            if($this->tarif->loaded()){
                return $this->tarif->h1; 
            }       
        }
        return NULL;
    }
    
    public function active()
	{
	   if(! $this->active)
       {
          return t('card.status.empty');
       }
       return t('card.status.active', array('active' => date('d.m.Y H:i:s', $this->active_time), 'start' => date('d.m.Y H:i:s', $this->start_time)));
	}
    
    // пересчет
    public function calc($summa = NULL,$currency = NULL,$inc = TRUE, $type = NULL){
        if($summa > 0){
            $_action = NULL;
            $current_summa = $this->ball;
            if($currency instanceof ORM){
                $_currency = $currency;
            }else{
                if(! $currency){
                    $_currency = ORM::factory('currency')->_default();
                }else{
                    $_currency = ORM::factory('currency',intval($currency));
                }
            }
           
            
            if($_currency->loaded()){
                if($this->currency->loaded()){
                    if($this->currency->id != $_currency->id){
                        //$curs = $_currency->curs($this->currency->id);
                        $curs = $this->currency->curs($_currency->id);
                        if($curs){
                           $summa = round($summa * $curs, 2); 
                        }
                        $this->currency = $_currency;
                    }
                }else{
                    $this->currency = $_currency;
                }
            }
            
            if(! $inc){
                if($summa > $current_summa){
                    $_action = 'add'.($type ? '_'.strtolower($type) : '');
                    $_ball = $summa - $current_summa;
                }elseif($summa < $current_summa){
                    $_action = 'write'.($type ? '_'.strtolower($type) : '_admin');
                    $_ball = $current_summa - $summa;
                }
                $this->ball = $summa;
            }else{
                if($inc > 0){
                    $_action = 'add'.($type ? '_'.strtolower($type) : '');
                    $_ball = $this->ball + $summa; 
                    $this->ball = $_ball;  
                }else{
                    $_action = 'write'.($type ? '_'.strtolower($type) : '_admin');
                    $_ball = $this->ball - $summa; 
                    $this->ball = $_ball;
                }
            }
            if($_action){
                $event = ORM::factory('event')->add_event($this, $_action, array('ball' => $_ball));
                if($event->loaded()){
                    $this->last_event = $event->id;
                }                
            }
        }
        return $this;
    }
    
    public function calc_tarif($update = TRUE){
        if($this->loaded()){
            if($update){
                $tarifs = ORM::factory('tarif')->order_by('from_value', 'desc')->find_all();
                $total = $this->ball;
                $c_tarif = $this->tarif;  
                $currency = $this->currency;
                $prev = $_c_tarif = NULL;
                foreach($tarifs as $tarif){
                    if($this->currency->id !== $tarif->from_currency->id){
                        $curs = $this->currency->curs($tarif->from_currency->id);
                        if($curs){
                           $_total = round($total * $curs, 2); 
                        }
                    }else{
                        $_total = $total;
                    }
                    if($_total > $tarif->from_value AND $_total <= $tarif->to_value){
                        $this->tarif = $tarif;
                        $this->percent = $tarif->percent;  
                        return;
                    }elseif($_total > $tarif->to_value){
                        $this->tarif = $tarif;
                        $this->percent = $tarif->percent;
                        return;
                    }
                }    
            }
            return $this->tarif;
        }
    }
    
    
    
    public function isactive($inc = TRUE){
        if($this->loaded()){
            if($inc){
                if($this->active AND $this->active_time > time() AND $this->start_time < time()){
                    return TRUE;              
                }    
            }else{
                if($this->active){
                    return TRUE;              
                } 
            }
        }
        return FALSE;            
    }
    
    public function income($show = FALSE){
        $income = NULL;
        if($this->isactive(FALSE)){
            $time = time();
            if($time >= $this->active_time){
               $time = $this->active_time;
            }
            $long = $time - $this->start_time;
            $long =  floor($long/Date::DAY);
            $value = $this->ball * $this->percent * 0.01 *  $long;
            $_value = self::summa_format($value);
            if(! $show){
                $income = '<div class="income"><span class="label">'.t('card.income').':</span>'.$_value.''.$this->currency->render().' - '.$this->percent.'%</div>';
            }else{
                $income = array('value' => $value, 'currency' => $this->currency);
            }
        } 
        return $income;           
    }
    
    public function summary_income($show = FALSE, $add_event = FALSE){
        $main_income = $this->income(TRUE);
        $summary = $main_income['value'];
        /*$referrals = $this->user->referrals();
        if(! empty($referrals)){
            foreach($referrals as $referral){
               $summary += $referral['income'];
               // пока не учитываем курс валют
            }
        }
        */
        $summary += $this->referrals_income($add_event);
        $_summary = self::summa_format($summary);
        if(! empty($main_income)){
            if(! $show){
                $income = '<div class="income"><span class="label">'.t('card.income').':</span>'.$_summary.''.$main_income['currency']->render().' - '.$this->percent.'%</div>';
            }else{
                $income = array('value' => $summary, 'currency' => $main_income['currency']);
            }
            return $income; //array('value' => $summary, 'currency' => $main_income['currency']);
        }
    }
    
    public function referrals_income($add_event = FALSE){
       $summary = 0;
       $referrals = $this->user->referrals();
        if(! empty($referrals)){
            foreach($referrals as $referral){
               $summary += $referral['income'];
               if($add_event){
                    $_card = $referral['card'];
                    $o_referral = $referral['referral'];
                    if($o_referral->loaded()){
                        $o_referral->ball = $o_referral->ball + $referral['income'];
                        $o_referral->update();   
                    }
                    $event = ORM::factory('event')->add_event($this, 'add_referral', array('ball' => $referral['income']));
                    if($event->loaded()){
                        $this->last_event = $event->id;
                        $this->update();
                    }
               }
               // пока не учитываем курс валют
            }
        } 
        return $summary;
    }
    
    public function update_income($income = NULL){
        if($this->loaded()){
            if($this->income != $income){
                $this->income = $income;
                $this->update();
            }
        }
        return $income;
    }
    
    public function income_all($time = NULL){
        
    }
    
    public function activation($time = NULL){
        $this->active = 1;
        if(! $time){
            if($this->tarif->loaded()){
                $time = ($this->tarif->frost * Date::DAY) + time();
                $this->active_time = intval($time);
            }
        }else{
            if(intval($time) == 0){
                $time = strtotime($time);
            }
            if($time > time()){
                $this->active_time = $time;
            }
        }
        $this->start_time = time();
    }
    
    public function check_user($user = NULL)
	{
	   if($user instanceof ORM){
	       
           $card = ORM::factory('card')->where('user_id','=', $user->id)->find();
           if($card->loaded()){
              return $card;
           }
           return FALSE;    
	   }
       return NULL;
	}
    
    public function add_to_user($user){
        $card = $this->check_user($user);
        if($card === FALSE){
            $card = ORM::factory('card');
            $card_values = array();
            $card_values['code'] = $user->login;
            $card_values['active_time'] = 0;
            $card_values['active'] = 0;
            $card_values['created'] = time();
            $card->values($card_values);
            $card->user = $user;
            $card->create();
        }
        return $card;
    }
    
    
    public function url_admin($action)
	{
		return Site::url('/admin/card/'.$action.'/'.$this->id);
	}

	public function url()
	{
		return Site::url('/user/'.$this->login.'');
	}
    
    public function last_event($date = NULL)
    {
        if (! $this->last_event)
        {
            return false;
        }
        $event = ORM::factory('event', $this->last_event);
        if($date){
            //print_r($event->as_array());
        }
        return View::factory('admin/event/preview')->bind('event', $event)->render().($date ? date('d.m.Y H:i:s',$event->created).' ('.$event->ip.')' : '');
    }
    
    public static function allow_day($action = 'up'){
        $day = date('w');
        switch($action){
            case 'up':
            return TRUE;
            
            case 'out':
                $out_days = self::$out_days;
                if(in_array($day, $out_days)){
                    return TRUE; 
                }
            break;
            
            case 'out_percent':
                $out_days = self::$out_days;
                if(in_array($day, $out_days)){
                    return TRUE; 
                }
            break;
        }
        return FALSE;
    }
    /**
    * Проверяем 
    */
    public function allow($action = 'view'){
        if($this->loaded()){
            switch($action){
                case 'up':
                return self::allow_day($action);
                    /*if($this->active){
                        if($this->active_time > time()){
                            return FALSE;
                        }
                    }*/
                break;
                
                case 'out':
                    $day = date('w');
                    if($this->active){
                        if($this->active_time < time()){
                            /*if(self::$out_day == $day){
                                return TRUE;
                            }*/
                            return self::allow_day($action);
                        }else{
                            /*if(self::$out_day == $day){
                                return TRUE;
                            }*/
                        }
                    }else{
                        if($this->ball > 0){
                            return self::allow_day($action);
                        }else{
                           
                        }
                    }
                    return FALSE; 
                break;
                
                case 'out_percent':
                  if($this->active){
                      if(self::allow_day($action)){
                        $income =  $this->summary_income();
                        //$this->update_income($income['value']);
                        if($income['value'] >= Model_Bill::$min_summa){
                            return TRUE;
                        }
                      }
                  }
                  
                break;
            }
        }
        return FALSE;
    }



}
 