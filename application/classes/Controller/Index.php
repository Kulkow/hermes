<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Index extends Controller_Layout
{
    
    public function action_index()
	{
	   Menu::$current = 'home';
       $this->template->content = View::factory('index');
       $blocks =  ORM::factory('page')
                			->with('content')
                			->where('pid', '=', 4)
                            ->limit(3)
                			->find_all();
       $this->template->bind_global('blocks',$blocks);
       
       
       /*
       foreach(ORM::factory('Role')->find_all() as $role){
           print_r($role->as_array());
       }
       $alias = 'super_referral';
       */
       /*if(! ORM::factory('Role', array('name' => $alias))->loaded()){
          echo 'no';
          $r = ORM::factory('Role')->values(array('name' => $alias, 'description' => 'Группа для рефералов с больщим процентом'));
          $r->save();
          print_r($r->as_array());
       }*/
       //
       /*
       if($this->auth_user){
            $_card = $this->auth_user->card();
            $time = time() - (Date::DAY * 7);
            $time2 = time() + (Date::DAY * 7);
            $_card->active = 1;
            $_card->active_time = $time2;
            $_card->start_time = $time;
            $_card->update();   
            $refferals = $this->auth_user->referrals(); 
            //print_r($refferals);
            foreach($refferals as $refferal){
                $_card = $refferal['card'];
                $_card->active = 1;
                $_card->active_time = $time2;
                $_card->start_time = $time;
                $_card->update();    
            }
            
       }
       */
       /*
       foreach(ORM::factory('user')->find_all() as $user){
          $refferal = ORM::factory('referral', array('user_id' => $user->id));
          
          if(! $refferal->loaded()){
              $refferal->user = $user;
              $refferal->save(); 
          }
       }*/
	}
}