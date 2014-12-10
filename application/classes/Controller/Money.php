<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Money extends Controller_Layout
{
	public $user;
    public $card;
    public $shot = NULL;
    
    public $menu_user = 'up';
    public $side_menu = 'profile';
    
    public $pay_type = 'qiwi';
    public $payment = NULL;
    
    public function before()
	{
        parent::before();
        if(! $this->auth_user)
        {
            Controller::redirect(Site::url('login'));
        }else{
            $this->card = $this->auth_user->card();
        }
        if(! $this->auth_user->allow($this->request->action()))
        {
           // $this->error(403);
        }
        $this->user = $this->auth_user;
       $this->site->assign($this->user->fullname());
	    
       $this->template->bind_global('shot', $this->shot);
       $this->template->bind_global('user', $this->user);
       $this->template->bind_global('card', $this->card);
       $this->template->bind_global('menu_user', $this->menu_user);
       $this->template->bind_global('side_menu', $this->side_menu);
       $this->template->content = View::factory('user/view');
       
       $this->template->bind_global('pay_type', $this->pay_type);
       if($this->request->param('type')){
            $this->pay_type = $this->request->param('type'); 
       }
       if($this->pay_type){
         $payment = ORM::factory('payment', array('alias' => $this->pay_type));
         if($payment->loaded()){
            $this->payment = $payment;
         }
       }
       $this->sidebar = TRUE;
       $this->side_menu = 'balans';
        	   
	}
    
    public function action_index()
	{

		$this->shot = View::factory('user/money/setup');
		/**
		 * SEO
		 */
		$this->site->assign($this->user->fullname());
	}
    
    /*public function action_events()
	{
	  $this->shot = View::factory('user/events'); 
	}*/
    
    public function action_up()
	{
	   if($this->card->allow('up')){
           $method = '_up_'.$this->pay_type;
           if(method_exists($this,$method)){
               return $this->$method();
           }
       }else{
           $this->shot = View::factory('user/money/allow/up'); 
       }    
	}
    
    protected function _up_qiwi(){
        $session = Session::instance();
        $session_qiwi = $session->get('up_qiwi', NULL);
        if($session_qiwi > 0){
            $bill = ORM::factory('bill', intval($session_qiwi));
        }else{
            $bill = ORM::factory('bill');
        }
        if(! $bill->loaded()){
           $session_qiwi = NULL; 
           $session->set('up_qiwi', NULL);
        }
        $errors = array();
        $send = FALSE;
        if (HTTP_Request::POST == $this->request->method())
		{
			try
			{
				$values = $this->request->post();
                if($bill->loaded()){
                   $values['summa'] =  $bill->summa;
                }else{
                    if(Arr::get($values, 'summa', NULL)){
                        $values['summa'] = floatval($values['summa']);    
                    }
                }
                
                $validation = Validation::factory($values);
                $validation->rule('summa','not_empty');
                   //->rule('phone', 'not_empty')
                   $_send = FALSE;
                   if($bill->loaded()){
                        $validation->rule('phone', 'not_empty');
                        $_send = 1;
                   }
                   //$bill = ORM::factory('bill')->values($values);
                   $bill->values($values);
                   if(! $bill->loaded()){
                       $bill->card = $this->user->card();
                       $bill->currency =  $bill->default_currency();
                       $bill->type = $this->pay_type;
                   }
                   $bill->created = time();
                   $bill->save($validation);
                   if($bill->loaded()){
                       $session->set('up_qiwi', $bill->id);
                   }
                    if(empty($errors)){
                        //$send = "https://w.qiwi.com/order/external/main.action?shop=".$this->payment->login."&transaction=".$bill->id;
                        if($_send){
                            $send = "https://visa.qiwi.ru/payment/form.action?provider=99";
                            $email = $this->site->admin_email();
                            $params = array('user' => $this->user, 'bill' => $bill);
                            Site::email($email, 'money', 'qiwi_up', $params);    
                            $session->set('up_qiwi', NULL);
                        }
                   }                    
            }
            catch (ORM_Validation_Exception $e)
    		{
    				$_REQUEST = Arr::merge($_REQUEST, $values);
    				$errors = $e->errors('qiwi');
    		}
          }
          $this->shot = View::factory('user/money/'.'up_'.$this->pay_type)->bind('errors', $errors)->bind('send', $send);
          $this->shot->bind_global('payment', $this->payment);
          $this->shot->bind_global('session_qiwi', $session_qiwi);
          $this->shot->bind_global('bill', $bill);             
    }
    
    protected function _up_qiwi_auto(){
        return FALSE;
        $errors = array();
        $send = FALSE;
        if (HTTP_Request::POST == $this->request->method())
		{
			try
			{
				$values = $this->request->post();
                $values['summa'] = floatval($values['summa']);
                $validation = Validation::factory($values);
                $validation->rule('phone', 'not_empty')
                   ->rule('summa','not_empty')
                   ->rule('summa', 'decimal');
                   $bill = ORM::factory('bill')->values($values);
                   $bill->card = $this->user->card();
                   $bill->type = $this->pay_type;
                   $bill->created = time();
                   $bill->create($validation);
                   
            		// уведомлять пользователя о выставленном счете (0 - нет, 1 - послать СМС, 2 - сделать звонок)
		            // уведомления платные для магазина, доступны только магазинам, зарегистрированным по схеме "Именной кошелёк"
                    $alarm = 0;
                    $qiwi = QIWI::factory();
            		$rc = $qiwi->createBill($bill->phone, $bill->summa, $bill->id, $bill->comment, $alarm);
                    $rc = intval($rc);
                    if($rc > 0){
                       $errors['create'] = t('qiwi.'.$rc); 
                    }
                    if(empty($errors)){
                        $send = "https://w.qiwi.com/order/external/main.action?shop=".$qiwi->login."&transaction=".$bill->id;
                        $email = $this->site->admin_email();
                        $params = array('user' => $this->user, 'bill' => $bill);
                        Site::email($email, 'money', 'qiwi_up', $params);
                   }                    
            }
            catch (ORM_Validation_Exception $e)
    		{
    				$_REQUEST = Arr::merge($_REQUEST, $values);
    				$errors = $e->errors('qiwi');
    		}
          }
          $this->shot = View::factory('user/money/'.'up_'.$this->pay_type)->bind('errors', $errors)->bind('send', $send);
          $this->shot->bind_global('payment', $this->payment);            
    }
    
    protected function _up_perfect(){
        $errors = array();
        $send = false;
        $card = $this->user->card();
        $bill = ORM::factory('bill')->check_exists('perfect', $card);
        if($bill === FALSE){
            if (HTTP_Request::POST == $this->request->method())
    		{
    			try
    			{
    				$values = $this->request->post();
                    if(Arr::get($values, 'summa', NULL)){
                        $values['summa'] = floatval($values['summa']);
                    }
                    $validation = Validation::factory($values);
                    $validation->rule('summa','not_empty');
                       $bill = ORM::factory('bill')->values($values);
                       $bill->card = $this->user->card();
                       $bill->type = $this->pay_type;
                       $bill->created = time();
                       $bill->currency =  $bill->default_currency();
                       $bill->save($validation);
                       
                       $perfectmoney = Perfectmoney::factory();
                       $perfectmoney->params($bill);
                       $send = $perfectmoney->data;
                       $email = $this->site->admin_email();
                       
                       //Site::email($email, 'money', 'perfect_up', $params);
                        
                }
                catch (ORM_Validation_Exception $e)
        		{
        				$_REQUEST = Arr::merge($_REQUEST, $values);
        				$errors = $e->errors('perfect');
        		}
              }
          }else{
               $perfectmoney = Perfectmoney::factory();
               $perfectmoney->params($bill);
               $send = $perfectmoney->data;
          }    
          $this->shot = View::factory('user/money/'.'up_'.$this->pay_type)->bind('errors', $errors)->bind('send', $send);
          $this->shot->bind_global('payment', $this->payment);
    }
    
    
    public function action_out()
	{
	   if($this->card->allow('out')){
           $method = '_out_'.$this->pay_type;
           $this->menu_user = 'out';
           if(method_exists($this,$method)){
               return $this->$method();
           }
       }else{
           $this->shot = View::factory('user/money/allow/out'); 
       } 
	}
    
    public function action_out_percent()
	{
	   if($this->card->allow('out_percent')){
           $method = 'out_percent'.$this->pay_type;
           $this->menu_user = 'out_percent';
           if(method_exists($this,$method)){
               return $this->$method();
           }
       }else{
           $this->shot = View::factory('user/money/allow/out_percent'); 
       } 
	}
    
    protected function _out_qiwi(){
        $errors = array();
        $send = FALSE;
        $bills_out = ORM::factory('bill')->where('card_id','=',$this->card->id)->and_where('status', '=', 5)->and_where('type', '=', $this->pay_type)->find_all();
        if (HTTP_Request::POST == $this->request->method())
		{
				try{
                    $values = $this->request->post();
                    //$values['summa'] = floatval($values['summa']);
                    $validation = Validation::factory($values);
                    $validation->rule('phone', 'not_empty')
                       ->rule('summa','not_empty')->rule('summa', array($this, 'allow_uot'), array($this->card,':value'));
                       //->rule('summa', 'decimal');
                       
                   $bill = ORM::factory('bill')->values($values);
                   $bill->card = $this->card;
                   $bill->type = $this->pay_type;
                   $bill->created = time();
                   $bill->status = 5;
                   $bill->currency =  $bill->default_currency();
                   $bill->save($validation);   
                   
                   $this->card->ball = $this->card->ball -  $bill->summa;
                   $this->card->update();    
                    //if($post->check()){
                    $email = $this->site->admin_email();
                    $params = array('user' => $this->user, 'post' => $values);
                    Site::email($email, 'money', 'qiwi_out', $params);
                    $send = TRUE;
                 
                }
                catch (ORM_Validation_Exception $e)
        		{
        				$_REQUEST = Arr::merge($_REQUEST, $values);
        				$errors = $e->errors('perfect');
        		}  
                       
                        
          
          }
          $this->shot = View::factory('user/money/'.'out_'.$this->pay_type)->bind('errors', $errors)->bind('send', $send)->bind('bills_out',$bills_out); 
          $this->shot->bind_global('payment', $this->payment);  
    }
    
    public static function allow_uot($card, $value){
        if($card->loaded()){
            return $card->ball >= $value;
        }
        return FALSE; 
    }
    
    public static function allow_uot_percent($card, $value){
        if($card->loaded()){
            return $card->income >= $value;
        }
        return FALSE; 
    }
    
    protected function _out_perfect(){
        $errors = array();
        $send = FALSE;
        $bills_out = ORM::factory('bill')->where('card_id','=',$this->card->id)->and_where('status', '=', 5)->and_where('type', '=', $this->pay_type)->find_all();
        
        if (HTTP_Request::POST == $this->request->method())
		{
			try{
            	$values = $this->request->post();
                //$values['summa'] = floatval($values['summa']);
                $validation = Validation::factory($values);
                $validation->rule('akkaunt', 'not_empty')
                   ->rule('summa','not_empty')->rule('summa', array($this, 'allow_uot'), array($this->card,':value'));
                   //->rule('summa', 'decimal');
                   
               $bill = ORM::factory('bill')->values($values);
               $bill->card = $this->card;
               $bill->type = $this->pay_type;
               $bill->created = time();
               $bill->status = 5;
               $bill->currency =  $bill->default_currency();
               $bill->save($validation);   
               
               $this->card->ball = $this->card->ball -  $bill->summa;
               $this->card->update();    
                //if($post->check()){
                $email = $this->site->admin_email();
                $params = array('user' => $this->user, 'post' => $values);
                Site::email($email, 'money', 'perfect_out', $params);
                $send = TRUE;
            }
            catch (ORM_Validation_Exception $e)
    		{
    				$_REQUEST = Arr::merge($_REQUEST, $values);
    				$errors = $e->errors('perfect');
    		}  
                       
                        
          
          }
        $this->shot = View::factory('user/money/'.'out_'.$this->pay_type)->bind('errors', $errors)->bind('send', $send)->bind('bills_out',$bills_out);
        $this->shot->bind_global('payment', $this->payment);
    }
    
    protected function _out_percent_qiwi(){
        $errors = array();
        $send = FALSE;
        $income = $this->card->summary_income(); 
        $this->card->update_income($income['value']);
        $bills_out = ORM::factory('bill')->where('card_id','=',$this->card->id)->and_where('status', '=', 6)->and_where('type', '=', $this->pay_type)->find_all();
        if (HTTP_Request::POST == $this->request->method())
		{
				try{
                    $values = $this->request->post();
                    $validation = Validation::factory($values);
                    $validation->rule('phone', 'not_empty')
                       ->rule('summa','not_empty')->rule('summa', array($this, 'allow_uot_percent'), array($this->card,':value'));
                       //->rule('summa', 'decimal');
                       
                   $bill = ORM::factory('bill')->values($values);
                   $bill->card = $this->card;
                   $bill->type = $this->pay_type;
                   $bill->created = time();
                   $bill->status = 6;
                   $bill->currency =  $bill->default_currency();
                   $bill->save($validation);   
                   
                   $this->card->ball = $this->card->ball -  $bill->summa;
                   $this->card->update();    
                    $email = $this->site->admin_email();
                    $params = array('user' => $this->user, 'post' => $values);
                    Site::email($email, 'money', 'qiwi_out_percent', $params);
                    $send = TRUE;
                 
                }
                catch (ORM_Validation_Exception $e)
        		{
        				$_REQUEST = Arr::merge($_REQUEST, $values);
        				$errors = $e->errors('perfect');
        		}  
          }
          $this->shot = View::factory('user/money/'.'out_percent_'.$this->pay_type)->bind('errors', $errors)->bind('send', $send)->bind('bills_out',$bills_out)->bind('income',$income); 
          $this->shot->bind_global('payment', $this->payment);  
    }
    
   
    
    protected function _out_percent_perfect(){
        $errors = array();
        $send = FALSE;
        $income = $this->card->summary_income(); 
        $this->card->update_income($income['value']);
        $bills_out = ORM::factory('bill')->where('card_id','=',$this->card->id)->and_where('status', '=', 6)->and_where('type', '=', $this->pay_type)->find_all();
        
        if (HTTP_Request::POST == $this->request->method())
		{
			try{
            	$values = $this->request->post();
                //$values['summa'] = floatval($values['summa']);
                $validation = Validation::factory($values);
                $validation->rule('akkaunt', 'not_empty')
                   ->rule('summa','not_empty')->rule('summa', array($this, 'allow_uot_percent'), array($this->card,':value'));
                   //->rule('summa', 'decimal');
                   
               $bill = ORM::factory('bill')->values($values);
               $bill->card = $this->card;
               $bill->type = $this->pay_type;
               $bill->created = time();
               $bill->status = 6;
               $bill->currency =  $bill->default_currency();
               $bill->save($validation);   
               
               $this->card->ball = $this->card->ball -  $bill->summa;
               $this->card->update();    
                //if($post->check()){
                $email = $this->site->admin_email();
                $params = array('user' => $this->user, 'post' => $values);
                Site::email($email, 'money', 'perfect_out_percent', $params);
                $send = TRUE;
            }
            catch (ORM_Validation_Exception $e)
    		{
    				$_REQUEST = Arr::merge($_REQUEST, $values);
    				$errors = $e->errors('perfect');
    		}  
                       
                        
          
          }
        $this->shot = View::factory('user/money/'.'out_percent_'.$this->pay_type)->bind('errors', $errors)->bind('send', $send)->bind('bills_out',$bills_out)->bind('income',$income);
        $this->shot->bind_global('payment', $this->payment);
    }
}