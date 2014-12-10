<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_User extends Model_Auth_User {
    
    public $card = NULL;
    
    /**
	 * Labels for fields in this model
	 *
	 * @return array Labels
	 */
	public function labels()
	{
		return array(
			'username'         => 'Логин',
			'email'            => 'Email',
			'password'         => 'Пароль',
            'name'             => 'ФИО',
            'address'          => 'Адрес',
            'phone'            => 'Телефон',
            'vk'               => 'Адрес Вконтакте', 
		);
	}
    
    public function complete_login()
	{
		if ($this->_loaded)
		{
			// Update the number of logins
			$this->logins = new Database_Expression('logins + 1');

			// Set the last login date
			$this->last_login = time();

			// Save the user
            try{
			 $this->update();
            }
			catch (ORM_Validation_Exception $e)
			{
				$errors = $e->errors('user');
                print_r($errors);
			}
		}
	}
    
    /*
    protected $_belongs_to = array(
    		'card'		=> array(
    			'model'		=> 'card',
    		),
    	);*/
    
    
    
    public static function valid_contact($user)
    {
       if($user instanceof ORM)
       {
          if(! empty($user->email) OR ! empty($user->phone))
          {
             RETURN TRUE;
          }
       }
       RETURN FALSE;
    }
    
    /**
    * FOR ORM 
    */
    public static function unique_card($login = NULL)
    {
       if($login)
       {
          $card = ORM::factory('card', array('code' => $login));
          if($card->loaded())
          {
            return FALSE;
          }
       }
       RETURN TRUE;
    }
    
    public function rules()
	{
		return array(
			'login' => array(
				array('not_empty'),
                array('min_length', array(':value', 4)),
				array('max_length', array(':value', 32)),
                array('alpha_numeric'),
               // array(array($this, 'valid_login'), array(':value')),
				array(array($this, 'unique'), array('login', ':value')),
                //array(array($this, 'unique_card'), array('login', ':value')),
			),
			'password' => array(
				array('not_empty'),
			),
			'email' => array(
				array('not_empty'),
				array('email'),
				array(array($this, 'unique'), array('email', ':value')),
                //array(array($this, 'valid_contact'), array($this)),
			),
            'phone' => array(
				array('not_empty'),
				//array('phone'),
			),
            'name' => array(
				array('not_empty'),
			),
		);
	}
    
    public static  function valid_login($login = NULL){
        return Valid::email($login) ? FALSE : TRUE;
    }
    
    public function card()
    {
       if($this->loaded())
       {
          $card = ORM::factory('card', array('user_id' => $this->id));
          if($card->loaded())
          {
            return $card;
          }
       }
       return FALSE;
    }
    
    public function url_admin($action)
	{
		return Site::url('/admin/user/'.$action.'/'.$this->id);
	}

	public function url($action = NULL)
	{
		return Site::url('/user/'.$this->login.'/'.$action);
	}
    
    public function url_referal(){
	   return URL::site('/registr?referral='.$this->login, 'http');
	}
    
    
    public function fullname()
	{
	   return ($this->name ? $this->name : $this->login);
	}
    
    public function allow($action)
    {
        $auth_user = Auth::instance()->get_user();
        if(! $auth_user)
        {
           return FALSE;    
        }
        if($this->login == $auth_user->login)
        {
           return TRUE;   
        }
        return FALSE;
    }
    
    public function check_create($login = NULL)
    {
        if($login)
        {
            $user = ORM::factory('user', array('login' => $login));
            if($user->loaded())
            {
                $role_login = ORM::factory('role', array('name' => 'login'));
                if(! $user->has('roles', $role_login->id))
                {
                    echo 'UPDATE';
                    return $user;
                } 
            }
        }
        return ORM::factory('user');
    }
    
    
    /*
    public function balance()
    {
        
        $card_id = intval($this->login);
        $bonus = ORM::factory('bonus')->where('ID', '=', $card_id)
                                      ->and_where('Active', '=', 1)->find_all();
                                      
        $balanse = 0;
        foreach($bonus as $operation)
        {
            //echo 'D-'.$operation->DEBKRED.'--o-'.$operation->Operation.'--'.$operation->sumBonus.'<br/>';
            if($operation->DEBKRED == 1)
            {
               $balanse = $balanse + $operation->sumBonus;
            }
            if($operation->DEBKRED == 0)
            {
              $balanse =  $balanse - $operation->sumBonus;
            }
        }
        return $balanse;
        
    }
    */
    
    public function balance($card = NULL)
    {
       if(! $card){
            $card = $this->card(); 
       }
       if($card == FALSE){
          return 0;
       }
       if($card->ball > 0){
            return $card->summa_format($card->ball); 
       }
       return $card->ball;
    }
    public function percent($card = NULL)
    {
       if(! $card){
            $card = $this->card(); 
       }
       if($card == FALSE){
          return 0;
       }
       return $card->percent;
    }
    
    public function delete()
    {
        if(! $this->loaded())
        {
            return FALSE;
        }
        if($this->login == 'admin')
        {
            return FALSE;
        }
       parent::delete();
    }
    
    public function referrals($income = TRUE){
        $_refferals = array();
        if($this->loaded()){
            $referral = ORM::factory('referral', array('user_id' => $this->id));
            if($referral->loaded()){
               $referrals = $referral->tree($referral->id);
               
               /**
                * Посчитаем проценты сразу
               */
               $config = Kohana::$config->load('referral'); 
               $super_referral = ORM::factory('role', array('name' => 'super_referral'));
               
               foreach($referrals as $_referral){
                  if($_referral->user->id !=  $this->id){
                    $_r =  array('user' => $_referral->user, 'level' => ($_referral->level - 1), 'card' => NULL,'percent' => 0, 'referral' => $_referral,'income' => 0);
                    if( $_referral->user->loaded()){
                       $_card =  $_referral->user->card();
                       if($_card){
                           $_r['card'] = $_card;
                           if($income){
                               $type = 'default';
                               if($_referral->user->has('roles', $super_referral)){
                                    $type = 'super_referral';
                               }
                               $_config = Arr::get($config, $type, NULL); // дефолт
                               $percent = Arr::get($_config,$_r['level']);
                               $_r['percent'] = $percent;
                               $_r['income'] = 0; 
                               if($_r['card']->isactive()){
                                  $_income = $_r['card']->income(TRUE);
                                  if(! empty($_income)){
                                    $_r['income'] = $percent/100 * $_income['value'];
                                  }
                               }
                               $_r['currency'] = $_r['card']->currency;
                               $_r['all_income'] = $_referral->ball + $_r['income'];
                           }
                        }
                    }
                    $_refferals[] = $_r;  
                  }
                  
               } 
            }else{
                // create
            }
        }
        return $_refferals;
    }
	
}