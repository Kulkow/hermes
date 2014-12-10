<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User extends Controller_Layout
{
	public $user;
    public $card;
    public $shot = NULL;
    
    public $menu_user = 'main';
    public $side_menu = 'profile';
    
    public function before()
	{
        parent::before();
        $this->user = ORM::factory('user', array('login' => $this->request->param('id')));
        if(! $this->user->loaded())
        {
            $this->error(404);
        }else{
            $this->card = $this->user->card();
        }
        if(! $this->user->allow($this->request->action()))
        {
            $this->error(403);
        }
        
       $this->site->assign($this->user->fullname());
	    
       $this->template->bind_global('shot', $this->shot);
       $this->template->bind_global('user', $this->user);
       $this->template->bind_global('card', $this->card);
       $this->template->bind_global('menu_user', $this->menu_user);
       $this->template->bind_global('side_menu', $this->side_menu);
       $this->template->content = View::factory('user/view');
       
       $this->sidebar = TRUE;
       
       $this->side_menu = $this->request->action();
        	   
	}
    
    public function action_index()
	{

		$this->shot = View::factory('user/main');
		/**
		 * SEO
		 */
		$this->site->assign($this->user->fullname());
	}
    
    /*public function action_events()
	{
	  $this->shot = View::factory('user/events'); 
	}*/
    
    
    public function action_setting()
	{
      $this->action_profile(); 
	}
    
    public function action_profile()
	{
        $this->menu_user = 'profile';
        
        $this->menu = 'setting';
         
        $_key = array('email','phone');
        $_key = array_flip($_key);
        $old_data = array_intersect_key($this->user->as_array(), $_key);
        $save = NULL;
        if (HTTP_Request::POST == $this->request->method())
		{
			try
			{
				$values = $this->request->post();
                $new_data = array_intersect_key($values, $_key);
                $diff = array_diff ($old_data, $new_data);
				$this->user->values($values)->update();
                if(! empty($diff))
                {
                   /**
                   * SEND OLD EMAIL PHONE
                   */
                   Subshrieb::send($this->user, 'edit', array(),$diff);
                }
                Subshrieb::send($this->user, 'edit');
                $save = 1;
			}
			catch (ORM_Validation_Exception $e)
			{
				$_REQUEST = Arr::merge($_REQUEST, $values);
				$errors = $e->errors('user');
			}
		}
		else
		{
			$_REQUEST = Arr::merge($_REQUEST, $this->user->as_array());
		}

      $this->shot = View::factory('user/setting')->bind('errors', $errors)->bind('save', $save); 
	}
    
    static function check_password($value)
    {
      return Auth::instance()->check_password($value);
    }
    
    public function action_new_password()
	{
	  	$this->menu_user = 'new_password';
        
        $this->menu = 'setting';
        
        if (HTTP_Request::POST == $this->request->method())
		{
			try
			{
               $post = $this->request->post();
               $validation = Validation::factory($post);
               $validation->rules('oldpassword', array(array('not_empty'),array(array($this,'check_password'))));
               $validation->rules('password', array(array('not_empty'), array('min_length', array(':value', 6)),array('equals', array(':value', Arr::get($post, 'confirmpassword', NULL)))));
               $this->user->password = $this->request->post('password');
               $this->user->update($validation);
               
               //$this->template->content = View::factory('auth/password')->bind('password',$post['new_password']);
                
                Subshrieb::send($this->user, 'new_password', array('password' => $post['password']));
                $this->template->bind_global('password', $post['password']);
                Controller::redirect($this->user->url('setting'));
			}
			catch (ORM_Validation_Exception $e)
			{
				$_REQUEST = Arr::merge($_REQUEST, $post);
				$errors = $e->errors('user');
			}
		}
		else
		{
			$_REQUEST = Arr::merge($_REQUEST, $this->user->as_array());
		}

        $this->shot = View::factory('user/setting/new_password')->bind('errors', $errors); 
	}
    
    public function action_subscription()
	{
	  	$this->menu_user = 'subscription';
        $this->menu = 'setting';
        
        $subshrieb = ORM::factory('subshrieb', array('user_id' => $this->user->id));
        if(! $subshrieb->loaded())
        {
           $subshrieb =  $subshrieb->default_create($this->user, 1, 1);
        }
        
        if (HTTP_Request::POST == $this->request->method())
		{
			try
			{
               $post = $this->request->post();
               $post['email'] = Arr::get($post, 'email', 0);
               $post['phone'] = Arr::get($post, 'phone', 0);
               $subshrieb->values($post);
               $subshrieb->save();
               
               Subshrieb::send($this->user, 'subshrieb', array('subshrieb' => $subshrieb));
               $this->template->bind_global('subshrieb_set', $subshrieb);
               //Controller::redirect($this->user->url('setting'));
			}
			catch (ORM_Validation_Exception $e)
			{
				$_REQUEST = Arr::merge($_REQUEST, $post);
				$errors = $e->errors('user');
			}
		}
        else
        {
           $_REQUEST = Arr::merge($_REQUEST, $subshrieb->as_array()); 
        }

        $this->shot = View::factory('user/setting/subshrieb')->bind('errors', $errors); 
	}
    /*
    public function action_reports()
	{
	   $this->menu = 'reports';
       
       $card_id = intval($this->user->login);
       $post = array();
       if (HTTP_Request::POST == $this->request->method())
	    {
		  $post = $this->request->post();
		}
       $bonus = ORM::factory('bonus')->where('ID', '=', $card_id)->and_where('Active', '=', 1);
       $from = Arr::get($post, 'from', NULL);
       $to = Arr::get($post, 'to', NULL);
       if($from AND $to)
       {
          $to = $this->conver_date($to);
          $from = $this->conver_date($from);
          $reports = $bonus->and_where('DATE', '<', $to)->and_where('DATE', '>', $from)->find_all();
       }
       elseif($from)
       {
          $from = $this->conver_date($from);
         $reports = $bonus->and_where('DATE', '>', $from)->find_all();
       }
       elseif($to)
       {
         $to = $this->conver_date($to);
         $reports = $bonus->and_where('DATE', '<', $to)->find_all();
       }
       else
       {
           $reports = $bonus->find_all();   
       }
       
       $this->shot = View::factory('user/reports')->bind('reports', $reports); 
       
	}
    */
    public function action_reports()
	{
	   $this->menu = 'reports';
       $per_page = 10;
       $page = $this->request->param('page', 1);
	   
            
       $card_id = intval($this->user->login);
       $post = array();
       if (HTTP_Request::POST == $this->request->method())
	    {
		  $post = $this->request->post();
		}
       $events = ORM::factory('event')->where('user_id', '=', $this->user->id);

       $from = Arr::get($post, 'from', NULL);
       $to = Arr::get($post, 'to', NULL);
       if($from AND $to)
       {
          $to = $this->conver_date($to);
          $from = $this->conver_date($from);
          $reports = $events->and_where('created', '<', $to)->and_where('created', '>', $from); //->offset(($page - 1) * $per_page)->limit($per_page)->find_all();
       }
       elseif($from)
       {
          $from = $this->conver_date($from);
         $reports = $events->and_where('created', '>', $from);//->offset(($page - 1) * $per_page)->limit($per_page)->find_all();
       }
       elseif($to)
       {
         $to = $this->conver_date($to);
         $reports = $events->and_where('created', '<', $to);//->offset(($page - 1) * $per_page)->limit($per_page)->find_all();
       }
       else
       {
           $reports = $events;//->offset(($page - 1) * $per_page)->limit($per_page)->find_all();   
       }
       $_events = $events;
       //print_r($events);
       $reports = $events->order_by('created','desc')->offset(($page - 1) * $per_page)->limit($per_page)->find_all();
       
       //print_r($reports);
       $total =  $reports->count();
       $paging = Paging::make($total, $page, 10, 4, $this->user->url('reports'));
       $this->shot = View::factory('user/reports')->bind('reports', $reports)->bind('paging',$paging); 
	}
    
    
    protected function conver_date($datetime = NULL)
    {
        return strtotime($datetime);
    }
    
    public function action_order()
	{
	   $this->shot = View::factory('user/order'); 
	}
    
    public function action_plan()
	{
       $plans = ORM::factory('deferred')->where('user_id', '=', $this->user->id)->and_where('accrual', '>', time())->find_all();
       $this->shot = View::factory('user/plan')->bind('plans',$plans); 
	}
    
    public function action_balans()
	{
      $card = $this->user->card();
      $balance = $this->user->balance($card);
      $percent = $this->user->percent($card);
      $referals = array();
      $this->shot = View::factory('user/balans')->bind('balance', $balance)->bind('plans',$plans)->bind('count',$count)->bind('referals',$referals); 
	}
    
    public function action_start()
	{
	   $card = $this->user->card();
       if(! $card->isactive()){
           if($card->ball > 50){
               $card->activation();
               $card->update();
               $this->shot = '';
               Controller::redirect($this->user->url());
           }
       }
	}
    
    public function action_referral()
	{
      $referrals = array();
      $referrals = $this->user->referrals();
      $page = ORM::factory('page')->with('content')
			->where('alias', '=', 'referral')
			->find();
      $this->shot = View::factory('user/referral')->bind('referrals',$referrals)->bind('page',$page); 
	}
    
}