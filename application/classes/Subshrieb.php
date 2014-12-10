<?php defined('SYSPATH') or die('No direct script access.');

class Subshrieb
{
    
    public static function send($user, $action, $params = array(), $data = NULL)
    {
       if($user instanceof ORM)
       {
          if(! $user->loaded())
          {
            return false;
          }
          if(! $data)
          {
             $fields = $user->as_array(); 
          }
          else
          {
             $fields = $data;   
          }
          
   
          $phone = Arr::get($fields, 'phone', NULL);
          $email = Arr::get($fields, 'email', NULL);
          $subshrieb = ORM::factory('subshrieb', array('user_id' => $user->id));
          if(! $subshrieb->loaded())
          {
            /**
            * Добавляем подписку по-умолчанию
            */
            $subshrieb->default_create($user, $phone, $email);
          }
          if(Subshrieb::check_phone($phone))
          {
            if($subshrieb->phone)
            {
                $params['user'] = $user;
                $sms = SMS::instance();
                $sms->send($phone, $action, $params);
                //SMS::send($subshrieb->phone, $action, $params);
            }
          }
          else
          {
              //echo 'Error phone';
          }
          
          if(Valid::email($email))
          {
            if($subshrieb->email)
            {
                $params['user'] = $user;
                //Site::email($email, 'subshrieb', $action, $params);
            }
          }
       }   
    }
    
    public static function check_phone($phone = NULL)
    {
       if(! $phone)
       {
          return false;
       }
       if(! preg_match('/^\+?([87](?!95[4-79]|99[^2457]|907|94[^0]|336|986)([348]\d|9[0-689]|7[0247])\d{8}|[1246]\d{9,13}|68\d{7}|5[1-46-9]\d{8,12}|55[1-9]\d{9}|55119\d{8}|500[56]\d{4}|5016\d{6}|5068\d{7}|502[45]\d{7}|5037\d{7}|50[457]\d{8}|50855\d{4}|509[34]\d{7}|376\d{6}|855\d{8}|856\d{10}|85[0-4789]\d{8,10}|8[68]\d{10,11}|8[14]\d{10}|82\d{9,10}|852\d{8}|90\d{10}|96(0[79]|17[01]|13)\d{6}|96[23]\d{9}|964\d{10}|96(5[69]|89)\d{7}|96(65|77)\d{8}|92[023]\d{9}|91[1879]\d{9}|9[34]7\d{8}|959\d{7}|989\d{9}|97\d{8,12}|99[^4568]\d{7,11}|994\d{9}|9955\d{8}|996[57]\d{8}|9989\d{8}|380[34569]\d{8}|381\d{9}|385\d{8,9}|375[234]\d{8}|372\d{7,8}|37[0-4]\d{8}|37[6-9]\d{7,11}|30[69]\d{9}|34[67]\d{8}|3[12359]\d{8,12}|36\d{9}|38[1679]\d{8}|382\d{8,9})$/',$phone, $match))
       {
          return false;
       }  
       return TRUE;       
    }
     
}