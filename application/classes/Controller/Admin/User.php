<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_User extends Controller_Admin_Layout
{

    public $sort = 'created';
    public $up = 'desc';
    
    
    public function action_index()
	{
		
        if ($total = ORM::factory('user')->count_all())
		{
			$per_page = 20;
            $page = $this->request->param('page', 1);
			$paging = Paging::make($total, $page, $per_page, 4, 'admin/user');
			$users = ORM::factory('user')->order_by('created', 'desc')
				->offset(($page - 1) * $per_page)->limit($per_page)->find_all();
                
    	}
        
        $filters = Model_Filter::instance('user', array('filters' => array('login', 'phone', 'email'),
                                          'orders' => array('login', 'phone', 'email'))
                                          );
                                 
		$this->template->content = View::factory('admin/user/list')->bind('users', $users)->bind('paging', $paging);
	}
    
    /**
    * Проверяет нет ли такой карты
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
    
    /**
    * Добавляет пользователя и БК 
    *  Устанавливает время активации карты
    */
    
    public function action_add()
	{
		 $roles = $user_roles = array();
        $_roles = ORM::factory('role')->find_all();
        foreach($_roles as $_role){
           $roles[$_role->name] = $_role; 
        }
        /*
        foreach($user->roles->find_all() as $u){
            $user_roles[$u->name] = $u;
        }*/
        
        $referral = NULL;
        /*$main_refferal = ORM::factory('referral', array('user_id' => $user->id));
        
        if(! $main_refferal->loaded()){
            $main_refferal->user = $user;
            $main_refferal->save();
            
        }else{
            $pid = $main_refferal->get_pid();
            if($pid){
                $referral = $pid->user->login;  
            }
             
        }*/
        $this->template->bind_global('referral',$referral);   
        $this->template->bind_global('roles',$roles);
        $this->template->bind_global('user_roles',$user_roles); 
        if (HTTP_Request::POST == $this->request->method())
		{
        
            $user = ORM::factory('user');
            $values = $this->request->post();
            //$roles = $this->request->post('roles');
            $card = ORM::factory('card');
            
            
            try
            {
                $validation = Validation::factory($values);
                $validation->rules('login', array(array(array($this, 'unique_card'), array('login', ':value'))));
                $user->values($values);
                $user->created = time();
                
                $user->create($validation);
                //$user->add('roles', ORM::factory('role', array('name' => 'login')));
                
                if($_refferal = Arr::get($values, 'referral', NULL)){
                    $_refferal = trim($_refferal);
                    $refferal_user = ORM::factory('user', array('login' => $_refferal));
                    $referal_pid = ORM::factory('referral', array('user_id' => $refferal_user->id)); 
                    
                    
                    if($refferal_user->loaded()){
                        //$main_refferal->pid = $referal_pid->id;
                        $main_refferal = ORM::factory('referral')->values(array('pid' => $referal_pid->id, 'user_id' => $user->id));
                        $main_refferal->save();
                    }
                }
                 if($addrolles = Arr::get($values, 'addrolles', NULL)){
                    if(is_array($addrolles)){
                        $_user_roles = $user_roles; 
                        foreach($addrolles as $addrolle){
                            if(! Arr::get($user_roles,$addrolle, NULL)){
                                if($_role = Arr::get($roles,$addrolle, NULL)){
                                    $user->add('roles', $_role);
                                    //echo 'add('.$_role.')<br />';       
                                }
                            }else{
                                //echo 'unset('.$_role.')<br />';
                                unset($_user_roles[$addrolle]);    
                            }
                        }
                        if(! empty($_user_roles)){
                            foreach($_user_roles as $_user_role => $u){
                                if($_role = Arr::get($roles,$_user_role, NULL)){
                                    //echo 'remove('.$_role.')<br />';
                                    $user->remove('roles', $_role);       
                                }
                            }
                        }
                    }
                }
                $card->add_to_user($user);
                ORM::factory('log')->add_action($this->auth_user, 'add', $user);
                Controller::redirect('admin/user');
            }
            catch (ORM_Validation_Exception $e)
            {
                $_REQUEST = Arr::merge($_REQUEST, $values);
    			$errors = $e->errors('user');
            }
        }
        
        $this->template->content = View::factory('admin/user/edit')->bind('errors', $errors);
     }
     
     public function action_add_()
	{
		if (HTTP_Request::POST == $this->request->method())
		{
        
            $user = ORM::factory('user');
            $values = $this->request->post();
            //$roles = $this->request->post('roles');
            
            $card = ORM::factory('card');
            
            $roles = $user_roles = array();
            $_roles = ORM::factory('role')->find_all();
            foreach($_roles as $_role){
               $roles[$_role->name] = $_role; 
            }
            foreach($user->roles->find_all() as $u){
                $user_roles[$u->name] = $u;
            }
            
            $this->template->bind_global('roles',$roles);
            $this->template->bind_global('user_roles',$user_roles); 
             
            try
            {
                /*$validation = Validation::factory($values);
                $validation->rules('login', array(array($this, 'unique_card'), array('login', ':value')));
                */
                $user->values($values);
                $user->created = time();
                
                $user->create();
                //$user->add('roles', ORM::factory('role', array('name' => 'login')));
                if($_refferal = Arr::get($values, 'referral', NULL)){
                    $_refferal = trim($_refferal);
                    $refferal_user = ORM::factory('user', array('login' => $_refferal));
                    $referal_pid = ORM::factory('referral', array('user_id' => $refferal_user->id)); 
                    
                    
                    if($refferal_user->loaded()){
                        $main_refferal->pid = $referal_pid->id;
                        //$referal = ORM::factory('referral')->values(array('pid' => $referal_pid->id, 'user_id' => $user->id));
                        $main_refferal->save();
                    }
                }
                 if($addrolles = Arr::get($values, 'addrolles', NULL)){
                    if(is_array($addrolles)){
                        $_user_roles = $user_roles; 
                        foreach($addrolles as $addrolle){
                            if(! Arr::get($user_roles,$addrolle, NULL)){
                                if($_role = Arr::get($roles,$addrolle, NULL)){
                                    $user->add('roles', $_role);
                                    //echo 'add('.$_role.')<br />';       
                                }
                            }else{
                                //echo 'unset('.$_role.')<br />';
                                unset($_user_roles[$addrolle]);    
                            }
                        }
                        if(! empty($_user_roles)){
                            foreach($_user_roles as $_user_role => $u){
                                if($_role = Arr::get($roles,$_user_role, NULL)){
                                    //echo 'remove('.$_role.')<br />';
                                    $user->remove('roles', $_role);       
                                }
                            }
                        }
                    }
                }
                
                ORM::factory('log')->add_action($this->auth_user, 'add', $user);
                Controller::redirect('admin/user');
            }
            catch (ORM_Validation_Exception $e)
            {
                $_REQUEST = Arr::merge($_REQUEST, $values);
    			$errors = $e->errors('user');
            }
        }
        
        $this->template->content = View::factory('admin/user/edit')->bind('errors', $errors);
     }
     
    public function action_edit()
	{
		$user = ORM::factory('user', $this->request->param('id'));
        if ( ! $user->loaded())
        {
        	throw new HTTP_Exception_404();
		}
        $_key = array('email','phone');
        $_key = array_flip($_key);
        $old_data = array_intersect_key($user->as_array(), $_key);
        $referral = NULL;
        $main_refferal = ORM::factory('referral', array('user_id' => $user->id));
        
        if(! $main_refferal->loaded()){
            $main_refferal->user = $user;
            $main_refferal->save();
            
        }else{
            $pid = $main_refferal->get_pid();
            if($pid){
                $referral = $pid->user->login;  
            }
             
        }
               
        $roles = $user_roles = array();
        $_roles = ORM::factory('role')->find_all();
        foreach($_roles as $_role){
           $roles[$_role->name] = $_role; 
        }
        foreach($user->roles->find_all() as $u){
            $user_roles[$u->name] = $u;
        }
        
        $this->template->bind_global('roles',$roles);
        $this->template->bind_global('user_roles',$user_roles);
        $this->template->bind_global('referral',$referral);        

		if (HTTP_Request::POST == $this->request->method())
		{
			try
			{
				$values = $this->request->post();
                if(empty($values['password']))
                {
                    unset($values['password']);
                }
                /* Создать счет если его нет */
                $card = ORM::factory('card')->add_to_user($user);
                
				$user->values($values)->update();
                    /**
                * Включить рассылку.
                */
                if(Arr::get($values, 'send_user', NULL))
                {
                   $new_data = array_intersect_key($values, $_key);
                   $diff = array_diff ($old_data, $new_data);
                   if(! empty($diff))
                   {
                       Subshrieb::send($user, 'edit', array(),$diff);
                    }
                    Subshrieb::send($user, 'edit'); 
                }
                
                
                
                
                //status
                /*if($status = Arr::get($values, 'status', NULL))
                {
                    switch($status)
                    {
                        case 'login':
                            //$role_login = ORM::factory('role', array('name' => 'login'));
                            if(! $user->has('roles', $roles['login']))
                            {
                                $user->add('roles', $roles['login']);
                            }
                        break;
                        
                        case 'admin':
                            //$role_login = ORM::factory('role', array('name' => 'login'));
                            //$role_admin = ORM::factory('role', array('name' => 'admin'));
                            if(! $user->has('roles', $roles['login']))
                            {
                                $user->add('roles', $roles['login']);
                            }
                            if(! $user->has('roles', $roles['admin']))
                            {
                                $user->add('roles', $roles['admin']);
                            }
                        break;
                    }
                }
                else
                {
                    //$role_login = ORM::factory('role', array('name' => 'login'));
                    //$role_admin = ORM::factory('role', array('name' => 'admin'));
                    if($user->has('roles', $roles['login']))
                    {
                        $user->remove('roles', $roles['login']);
                    }
                    if($user->has('roles', $roles['admin']))
                    {
                       $user->remove('roles', $roles['admin']);
                    }
                }
                */
                
                
               
                if($_refferal = Arr::get($values, 'referral', NULL)){
                    $_refferal = trim($_refferal);
                    $refferal_user = ORM::factory('user', array('login' => $_refferal));
                    $referal_pid = ORM::factory('referral', array('user_id' => $refferal_user->id)); 
                    
                    
                    if($refferal_user->loaded()){
                        $main_refferal->pid = $referal_pid->id;
                        //$referal = ORM::factory('referral')->values(array('pid' => $referal_pid->id, 'user_id' => $user->id));
                        $main_refferal->save();
                    }
                }
                
                if($addrolles = Arr::get($values, 'addrolles', NULL)){
                    if(is_array($addrolles)){
                        $_user_roles = $user_roles; 
                        foreach($addrolles as $addrolle){
                            if(! Arr::get($user_roles,$addrolle, NULL)){
                                if($_role = Arr::get($roles,$addrolle, NULL)){
                                    $user->add('roles', $_role);
                                    //echo 'add('.$_role.')<br />';       
                                }
                            }else{
                                //echo 'unset('.$_role.')<br />';
                                unset($_user_roles[$addrolle]);    
                            }
                        }
                        if(! empty($_user_roles)){
                            foreach($_user_roles as $_user_role => $u){
                                if($_role = Arr::get($roles,$_user_role, NULL)){
                                    //echo 'remove('.$_role.')<br />';
                                    $user->remove('roles', $_role);       
                                }
                            }
                        }
                    }
                }
                ORM::factory('log')->add_action($this->auth_user, 'edit', $user);
                Controller::redirect('admin/users');
			}
			catch (ORM_Validation_Exception $e)
			{
				$_REQUEST = Arr::merge($_REQUEST, $values);
				$errors = $e->errors('user');
			}
		}
		else
		{
			$_REQUEST = Arr::merge($_REQUEST, $user->as_array());
            $role_login = ORM::factory('role', array('name' => 'login'));
            $role_admin = ORM::factory('role', array('name' => 'admin'));
            if($user->has('roles', $role_login))
            {
                $_REQUEST['status'] = 'login';
            }
            if($user->has('roles', $role_admin))
            {
                $_REQUEST['status'] = 'admin';
            }
		}

		$this->template->content = View::factory('admin/user/edit')->bind('errors', $errors);
	}
    
    function  action_generate_pasword()
    {
        if ( ! $this->request->is_ajax())
		{
		  return $this->error(403);
		}
        $html = Text::random('distinct');
        exit(json_encode(array('html' => $html)));
        
    }
    
    public function action_delete()
	{
		$user = ORM::factory('user', $this->request->param('id'));
        if ( ! $user->loaded()){
        	throw new HTTP_Exception_404();
		}
        $user->delete();
        if ($this->request->is_ajax()){
			echo json_encode(array('error' => FALSE));
			exit();
		}
		else{
            Controller::redirect('admin/users');
		}
     }
    
    public function action_toggle()
	{
		$user = ORM::factory('user', $this->request->param('id'));
		$has = FALSE;
        if ( ! $user->loaded())
		{
			throw new HTTP_Exception_404();
		}
        $role_login = ORM::factory('role', array('name' => 'login'));
        $role_admin = ORM::factory('role', array('name' => 'admin'));
        if(! $user->has('roles', $role_admin))
        {
            if($user->has('roles', $role_login))
            {
                $has = 1;
                $user->remove('roles', $role_login);
            }
            else
            {
                $has = 0;
                $user->add('roles', $role_login);
            }    
        }
        
        

		if ($this->request->is_ajax())
		{
			echo json_encode(array('hide' => $has ? 1 : 0));
			exit();
		}
		else
		{
			//$this->request->redirect('admin/page');
            Controller::redirect('admin/users');
		}
	}   
 }       