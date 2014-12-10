<?php defined('SYSPATH') or die('No direct script access.');

class Model_Event extends ORM {

protected $_table_name = 'events';


protected $_belongs_to = array(
		/**
		 *  card карта  над которой произошло действие
		 */
		'card'		=> array(
			'model'		=> 'card',
		),
        'user'		=> array(
			'model'		=> 'user',
		),
        'type'		=> array(
			'model'		=> 'event_type',
		),
	);
    
/*protected $_has_many = array(
        'events' => array(
            'through' => 'cards_events'),
);
*/

public function rules()
	{
		return array(
			/*'code' => array(
				array('not_empty'),
				array('max_length', array(':value', 64)),
				array(array($this, 'unique'), array('code', ':value')),
			),*/
            /*'ball' => array(
				array('is_integer'),
			),*/
		);
	}

public function values(array $values, array $expected = NULL)
{
    $values['ip'] = Request::$client_ip;
	return parent::values($values, $expected);
}
    
public function filters()
	{
		return array(
			/*'ball' 	=> array(
				array('intval'),
			),*/
            
            /*'active_time' 	=> array(
				array('strtotime'),
			),*/
		);
	}

public function create(Validation $validation = NULL)
{
    $event = parent::create($validation);
    //$event->callback_add();
    return $event;
}

/**
*      active 	активация карты 	
       add 	использование БК для начисления бонусов с продажи 	
 	   add_pay 	начисление бонусов (выполняет отложено роботом с продажи) 	
 	   add_plus 	зачисление бонусов (на карту положили деньги, подарили) 	
 	   clear 	обнуление бонусов (сгорание при неиспользовании) 	
 	   deactivate 	отключение 	
 	   write 	расходование бонусов (оплачен товар бонусами)
* 
*/


public function callback_add()
{
   if(! $this->loaded())
   {
    return false;
   }
   
   $type = $this->type->code;
   $card = $this->card;
   if($card->loaded())
   {
       switch($type)
       {
          case 'active':
             if($card->active != 1)
             {
                $card->active = 1;
                $card->update();
             }
         break;
         
         case 'add':
            if($this->ball > 0)
            {
               $card->ball = $card->ball + $this->ball;
               $card->update();  
            }
         break;
         
         case 'add_qiwi':
            if($this->ball > 0)
            {
               $card->ball = $card->ball + $this->ball;
               $card->update();  
            }
         break;
         
         case 'add_perfect':
            if($this->ball > 0)
            {
               $card->ball = $card->ball + $this->ball;
               $card->update();  
            }
         break;
         
         case 'clear':
               $card->ball = NULL;
               $card->update();  
         break;
         
         case 'deactivate':
            if($card->active != 0)
             {
                $card->active = 0;
                $card->update();
             }
         break;
         
         case 'write':
            if($this->ball > 0)
            {
               $card->ball = $card->ball - $this->ball;
               $card->update();  
            }
         break;
         
         default:
         break;
    }
   }
}

public function allow_fields_card(){
    return array('percent', 'ball');
}

public function add_event($card, $action, $data = array(), $user = NULL)
{
    $event = ORM::factory('event');
    if($card instanceof ORM){
        if(! $card->loaded())
        {
            throw new HTTP_Exception_404();
        }
    }
    else{
       $card = ORM::factory('card', intval($card));
       if(! $card->loaded())
       {
            throw new HTTP_Exception_404();
       } 
    }
    
    if(intval($action) == 0)
    {
        $type = ORM::factory('event_type', array('code' => $action));
        if(! $type->loaded())
        {
            throw new HTTP_Exception_404();
        }
    }
    $event = ORM::factory('event');
    $allow = $this->allow_fields_card();
    $values = array(); 
    foreach($data as $key => $v){
        if(in_array($key, $allow)){
           $values[$key] = $v;
        }
    }
    $event->values($values);
    $event->created = time();
    $event->card = $card;
    $_user = $user ? $user : $card->user;
    if($_user instanceof ORM){
        $event->user = $_user;    
    }else{
        $_user = ORM::factory('user', intval($_user));
        $event->user = $_user;
    } 
    
    $event->type = $type; 
    $event->create();
    return $event;              
}    



}
 