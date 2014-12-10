<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Auth extends Controller_Layout
{
	public $session = NULL;

	public function before()
	{
		parent::before();
		$this->session = Session::instance();

		if ($this->auth_user)
		{
            Controller::redirect($this->session->get_once('refer_before_auth', '/'));
		}
	}

	public function action_login()
	{
        $ip = Request::$client_ip;
        $this->site->assign(t('auth.auth'));
 		$attempt = $this->session->get_once('attempt', 1);
		$this->template->content = View::factory('auth/login')->bind('errors', $errors)->set('captcha', $attempt > 2);
        
        
        /**
        * Firefall            
        */
        $firefall = null;
        if(Firefall::black_list($ip))
        {
            $firefall = true;
            $errors['firefall'] = t('auth.firefall.blacklist', array('ip' => $ip));
        }
        
        if($ex = Firefall::stop_list($ip))
        {
            $firefall = true;
            $ex = intval(-(time() - $ex)/60);
            $errors['firefall'] = t('auth.firefall.stoplist', array('ip' => $ip, 'expires' => $ex));
        }
        
        if(! $firefall)
        {
            /**
            * Time Stop LIST
            * 
            */
            $expires = Arr::get($this->site->_config, 'auth.expires', 15 * 60);
            /**
            * После $count_go_black в день отправляется в Блек 
            */
            $count_go_black = Arr::get($this->site->_config, 'auth.count_go_black', 30);
    
            if (HTTP_Request::POST == $this->request->method())
            {
           		if ($attempt > 5)
           		{
           			$errors['firefall'] = t('auth.stop_list', array('expires' => ($expires/60)));
                    $start = time();
                    $end = $start - 24*60*60;
                    $_stop = DB::query(Database::SELECT, 'SELECT `expires` FROM `stop_list` WHERE `ip`=:ip AND `expires`>:start AND `expires`<:end')
                                           ->param(':ip', $ip)
        	                               ->param(':start', $start)
                                           ->param(':end', $end);
                    $current_count = $_stop->execute()->count();
                    if($current_count > $count_go_black)
                    {
                        ORM::factory('blacklist')->values(array('ip' => $ip, 'active' => 1, 'created' => time()))->save();
                        $errors['firefall'] = t('auth.black_list', array('ip' => $ip));
                    }
                    else
                    {
                        
                        $time = time()+intval($expires);
                        $data = array('ip' => $ip, 'card' => $this->request->post('login'),'expires' => $time);
                        $stop_list = ORM::factory('stoplist')->values($data);
                        $stop_list->save();   
                    }
           		}
                else
                {
                    if ($attempt > 3 AND ! Captcha::valid($this->request->post('captcha')))
               		{
               			$errors['__external']['captcha'] = t('captcha.Captcha::valid');
               		}
               		else
               		{
        	    	    $remember = array_key_exists('remember', $this->request->post());
        
            	        if (Auth::instance()->login($this->request->post('login'), $this->request->post('password'), $remember))
                    	{
                            $auth_user = ORM::factory('user', array('login' => $this->request->post('login')));
                            /**
                             *  Отправим СМС
                            */
                             $_config_subshrieb = Kohana::$config->load('subshrieb');
                             $config_subshrieb = $_config_subshrieb->get('default');
                             if(Arr::get($config_subshrieb, 'login', NULL))
                             {
                                 $sms = SMS::instance();
                                 $send_params = array('user' => $auth_user);
                                 $sms->send($auth_user->phone, 'login', $send_params);
                             }
                            Controller::redirect($auth_user->url()); 
                            //Controller::redirect($this->session->get_once('refer_before_auth', '/'));
            	        }
                	    else
                    	{
                        	$errors['login'] = t('auth.auth.error');
        	            }
        	    	}
                }
    	    	$this->session->set('attempt', $attempt + 1);
            }
        }
	}

   public function action_registr()
   {
		$this->menu = 'registr';
        
        if ($this->session->get_once('registr') == 'ok')
		{
			$this->site->assign(t('auth.registr.success'));
			$this->template->content = View::factory('auth/registr/success');
			return TRUE;
		}

		$this->site->assign(t('auth.registr'));
		$this->template->content = View::factory('auth/registr')->bind('errors', $errors);

        if (HTTP_Request::POST == $this->request->method())
        {
        	try
        	{
                $post = $this->request->post();

				$validation = Validation::factory($post);

				$validation->rules('captcha', array(array('not_empty'), array('Captcha::valid')));
				$validation->rules('password', array(array('not_empty'), array('min_length', array(':value', 6)),array('equals', array(':value', Arr::get($post, 'confirmpassword', NULL)))));
				$validation->rules('agreement', array(array('not_empty')));
                $validation->rules('token_check', array(array('not_empty'), array(array($this,'token_check'), array($post))));
                $validation->rules('login', array(array(array($this,'card_check'))));
                
                $user = ORM::factory('user')->check_create(Arr::get($post, 'login', NULL)); 
                
                //$user = ORM::factory('user')->values($post);
                $user = $user->values($post);
                $user->created = time();

                $user->save($validation);
                
                
                

   				$token = ORM::factory('user_token')->create_new($user,
   					Kohana::$config->load('auth.shorttime'), array('password' => $post['password']));

                
                //if ($this->site->registr_activate)
                if (TRUE)
				{
			      	Site::email($user->email, 'auth', 'registr', array('user' => $user, 'token' => $token->token));
				}
				else
				{
                	Controller::redirect('activate/'.$token->token);
                    //$this->request->redirect('activate/'.$token->token);
				}

				$this->session->set('registr', 'ok');
                //$this->request->redirect('registr');
                Controller::redirect('registr');
            }
            catch (ORM_Validation_Exception $e)
            {
                $errors = $e->errors('auth');
            }
        }
	}
    
    
    /**
    * For ORM
    */
    /*public static function card_check($login = NULL)
    {
        if($login)
        {
           $card = ORM::factory('card', array('code' => $login));
           if($card->loaded())
           {
              return TRUE;
           } 
        }
        return FALSE;
    }
    
    
    public static function token_check($post = array())
     {
        $card_code = Arr::get($post,'login', NULL);
        $token_check = Arr::get($post,'token_check', NULL);
        if($card_code)
        {
          $card = ORM::factory('card', array('code' => $card_code));
          if($card->loaded())
          {
             $card_id = $card->id;
             $event = ORM::factory('event', array('card_id' => $card_id, 'type_id' => 1, 'code' => $token_check));
             if($event->loaded())
             {
                return TRUE;
             }           
          }
          
          // ограничены типы операций для чеков  1-add Начисление баллов с продажи
        }
        return FALSE;
     } 
    
    */
    
    public static function card_check($login = NULL)
    {
        if($login)
        {
           /*$card = DB::query(Database::SELECT, 'SELECT `ID` FROM `BD_Bonus` WHERE `ID`=:ID LIMIT 1')
                ->param(':ID', $login);
           $rows = $card->execute();
           $row = $rows->current();
           $ID = Arr::get($row,'ID', NULL);
           if($ID)
           {
              return TRUE;
           }*/
           $login = intval($login);
           $bonus = ORM::factory('bonus', array('ID' => $login));
           $user = ORM::factory('user', array('login' => $login));
           if($bonus->loaded() OR $user->loaded())
           {
              return TRUE;
           }
           
        }
        return FALSE;
    }
    
    
    public static function token_check_ms($post = array())
     {
        $card_code = Arr::get($post,'login', NULL);
        $token_check = Arr::get($post,'token_check', NULL);
        
        if($card_code)
        {
           $card_code = intval($card_code);
           $token_check = intval($token_check);
           $bonus = ORM::factory('bonus', array('ID' => $card_code, 'Keys' => $token_check, 'Active' => 1));
           if($bonus->loaded())
           {
              return TRUE;
           }
           
           
           
          /***
          * ограничены типы операций для чеков  2-add Начисление баллов с продажи
          */
        }
        return FALSE;
     }
     
     public function token_check($post = array())
     {
        $card_code = Arr::get($post,'login', NULL);
        $token_check = Arr::get($post,'token_check', NULL);
        
        if($card_code)
        {
           $card_operation = DB::query(Database::SELECT, 'SELECT `id` FROM `checks` WHERE `card`=:card AND `keys`=:keys LIMIT 1')
                ->param(':card', $card_code)
                ->param(':keys', $token_check);
           $rows = $card_operation->execute();
           $row = $rows->current();
           $ID = Arr::get($row,'id', NULL);
           if($ID)
           {
              return true;
           }
          /***
          * ограничены типы операций для чеков  2-add Начисление баллов с продажи
          */
        }
        return FALSE;
     }  

	public function action_activate()
	{
  		$token = ORM::factory('user_token', array('token' => $this->request->param('token')));
   		if ( ! $token->loaded() OR ! $token->user->loaded())
   		{
	   		$this->site->assign(t('auth.activate.error'));
			$this->template->content = View::factory('auth/activate/error');
			return FALSE;
   		}

   		$this->site->assign(t('auth.activate'));
   		$user = $token->user;
   		$user->add('roles', ORM::factory('role', array('name' => 'login')));
		$this->template->content = View::factory('auth/activate')->bind('user', $user);
		Site::email($user->email, 'auth', 'activate', array('user' => $user, 'password' => $token->password));
        //Site::email($user->email, 'auth', 'activate', array('user' => $user));
		$token->delete();
        
        // Очистить чеки
        ORM::factory('check')->clear_tresh($user->login);
	}

	public function action_forgot()
	{
		if ($this->session->get_once('forgot') == 'sended')
		{
			$this->site->assign(t('auth.forgot.sended'));
			$this->template->content = View::factory('auth/forgot/sended');
            $data_user = array();
            if($email = $this->session->get('email'))
            {
                $data_user['email'] = $email;
                $this->session->set('email', NULL);
            }
            if($phone = $this->session->get('phone'))
            {
                $data_user['phone'] = $phone;
                $this->session->set('phone', NULL);
            }
            $this->template->bind_global('data_user', $data_user);
            
			return TRUE;
		}

		$this->site->assign(t('auth.forgot'));
 		$attempt = $this->session->get_once('attempt', 1);
 		$this->template->content = View::factory('auth/forgot')->bind('errors', $errors)->set('captcha', $attempt > 2);

        if (HTTP_Request::POST == $this->request->method())
        {
       		$errors = NULL;

       		if ($attempt > 3 AND ! Captcha::valid($this->request->post('captcha')))
       		{
       			$errors['_external']['captcha'] = t('captcha.Captcha::valid');
       		}

       		$user = ORM::factory('user', array('login' => strtolower($this->request->post('login'))));

       		if ( ! $user->loaded())
       		{
       			$errors['login'] = t('auth.forgot.error');
        	}

       		if ($errors === NULL)
       		{
   				$token = ORM::factory('user_token')->create_new($user, Kohana::$config->load('auth.shorttime'));

				Site::email($user->email, 'auth', 'forgot', array('user' => $user, 'token' => $token->token));

   	    	    $this->session->set('forgot', 'sended');
                
                $this->session->set('email', Text::pick($user->email, 'email'));
                $this->session->set('phone', Text::pick($user->phone, 'phone'));
   	        	//$this->request->redirect('forgot');
               // Controller::redirect('forgot');
       		}
            $this->session->set('attempt', $attempt + 1);
    	}
	}

	public function action_confirm()
	{
   		$token = ORM::factory('user_token', array('token' => $this->request->param('token')));
   		if ( ! $token->loaded() OR ! $token->user->loaded())
   		{
   			$this->site->assign(t('auth.confirm.error'));
			$this->template->content = View::factory('auth/confirm/error');
			return TRUE;
   		}

   		$this->site->assign(t('auth.confirm'));
        $user = $token->user->values(array('password' => $password = Text::random()))->update();
		$this->template->content = View::factory('auth/confirm')->bind('user', $user);
		Site::email($user->email, 'auth', 'confirm', array('user' => $user, 'password' => $password));
		$token->delete();
	}

	public function action_cancel()
	{
   		$token = ORM::factory('user_token', array('token' => $this->request->param('token')));
   		if ( ! $token->loaded() OR ! $token->user->loaded())
   		{
   			$this->site->assign(t('auth.cancel.error'));
			$this->template->content = View::factory('auth/cancel/error');
			return TRUE;
   		}

   		$this->site->assign(t('auth.cancel'));
   		$user = $token->user;
 		$this->template->content = View::factory('auth/cancel')->bind('user', $user);
		$token->delete();
	}
}
