<?php defined('SYSPATH') or die('No direct script access.');

class Firefall
{
    public static function check_ip($ip = NULL)
    {
        if(! $ip)
        {
          return FALSE;  
        }
        $config = Kohana::$config->load('1c');
        $ips = $config->get('ips');
        if(in_array($ip,$ips))
        {
           return TRUE;
        }
        
        return FALSE;
    }
    
    /**
    * 
    * Hash = sha1(id_bonus_cart + secret_key + code_oper);
    1)	id_bonus_cart – номер карты
    2)	secret_key – секретный ключ (знают все роботы 1С и робот сайта).
    3)	code_oper – код операции
    */
    
    public static function encryption($data = array(), $type = 'md5')
    {
       $config = Kohana::$config->load('1c');
       $secret_key = $config->get('secret_key');
       $out = '';
       $out .= Arr::get($data, 'card_id');
       $out .= Arr::get($data, 'code');
       $out .= $secret_key;
//       echo $out;
       switch($type)
       {
         case 'sha1':
            $return = sha1($out);
         break;
         
         case 'md5':
            $return = md5($out);
         break;
         
         default:
            $return = sha1($out);
         break;
       }
       
       return $return;
    }
    
    
    
    public static function check_hash($data = array(), $type = 'md5')
    {
       $hash = Arr::get($data, 'hash', NULL);
       if(! $hash)
       {
           return FALSE;
       }
       $curr = Firefall::encryption($data, $type);
       
       /**
       * Перевожу в нижний регистра для 1С.
       */
       $hash = strtolower($hash);
       
       //echo $hash.'=='.$curr;
       return ($curr == $hash);
    }
    
    public static function black_list($ip = NULL)
    {
        if($ip)
        {
           $black_list = ORM::factory('blacklist', array('ip' => $ip));
           if(! $black_list->loaded())
           {
              return FALSE;              
           }   
        }
        return TRUE;
    }
    
    public static function stop_list($ip = NULL)
    {
        if($ip)
        {
          $stop_list = DB::query(Database::SELECT, 'SELECT `expires` FROM `stop_list` WHERE `ip`=:ip AND `expires`>:expires ORDER BY `expires` DESC LIMIT 1')
                ->param(':ip', $ip)
	            ->param(':expires', time());
           $rows = $stop_list->execute();
           $row = $rows->current();
           $ex = Arr::get($row,'expires', NULL);
           if(! $ex)
           {
              return FALSE;              
           }
           return  $ex;
        }
        return TRUE;
    }
    
}