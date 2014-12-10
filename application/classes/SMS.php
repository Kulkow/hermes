<?php defined('SYSPATH') or die('No direct access allowed.');

Class SMS
{
    public static $instance = NULL;
    public $config = NULL;
    
    protected $client = NULL; 
      
      public static function instance()
      {
         if(! self::$instance)
         {
            $sms = new SMS;
            $config = Kohana::$config->load('sms');
            $config = $config->get('soap');
            $sms->config = $config;
            $sms->client = new SoapClient ("http://smsc.ru/sys/soap.php?wsdl");
            self::$instance = $sms;
         }
         return self::$instance;
      }

    // Отправка сообщения
    
    public function send($phone = NULL, $template = NULL, $params = array())
    {
           
        return TRUE;
        //$client = new SoapClient ("http://smsc.ru/sys/soap.php?wsdl");
        //print_r($params);
        $data = $this->config;
        $user = Arr::get($params, 'user', NULL); // $params['user'];
        //$data['mes'] = View::factory('sms'.($template ? '/'.$template : '/index'))->bind('params', $params)->render();
        $data['mes'] = View::factory('sms'.($template ? '/'.$template : '/index'))->bind('params', $params)->render();
        $data['phones'] = $user->phone; 
        $data['time'] = 0; 
        $soap = $this->client->send_sms($data);
        $result = $soap->sendresult;
        if (! empty($result->error))
        {
            //echo t('sms.api.send.'.$result->error);
            ORM::factory('log')->add_action($user, 'sms_send', t('sms.api.send.'.$result->error));
        }    
        else 
        {
            /*echo $result->id, "\n";
            echo $result->balance, "\n";
            echo $result->cost, "\n";
            echo $result->cnt, "\n";
            */
            return TRUE;
        }
        
     
    }

    public function flash()
    {
        //Flash сообщение от отправителя "ivan", которое должно быть доставлено абоненту 01.01.2012 г. в 00:00:
        
        $ret = $client->send_sms2(array("login"=>"alex", "psw"=>"123", "phones"=>"79999999999", "mes"=>"Hello world!", "id"=>"", "sender"=>"ivan", "time"=>"0101120000", "query"=>"flash=1"));
        
        if ($ret->sendresult->error)
            echo "Ошибка №".$ret->sendresult->error;
        else {
            echo $ret->sendresult->id, "\n";
            echo $ret->sendresult->balance, "\n";
            echo $ret->sendresult->cost, "\n";
            echo $ret->sendresult->cnt, "\n";
        }
        
    }


    public function multy()
    {
        //Несколько сообщений разным абонентам:
        
        $ret = $client->send_sms2(array("login"=>"alex", "psw"=>"123", "phones"=>"", "mes"=>"", "id"=>"", "sender"=>"", "time"=>0, "query"=>"list=79999999999:message1%0A79999999998:message2"));
        
        if ($ret->sendresult->error)
            echo "Ошибка №".$ret->sendresult->error;
        else {
            echo $ret->sendresult->id, "\n";
            echo $ret->sendresult->balance, "\n";
            echo $ret->sendresult->cost, "\n";
            echo $ret->sendresult->cnt, "\n";
        }
    }

    public function payment()
    {
        // Получение стоимости
        
        $ret = $client->get_sms_cost(array("login"=>"alex", "psw"=>"123", "phones"=>"79999999999", "mes"=>"Hello world!"));
        
        if ($ret->costresult->error)
            echo "Ошибка №".$ret->costresult->error;
        else {
            echo $ret->sendresult->cost, "\n";
            echo $ret->sendresult->cnt, "\n";
        }
    }

    public function status()
    {
    // Проверка статуса
    
    $ret = $client->get_status(array("login"=>"alex", "psw"=>"123", "phone"=>"79999999999", "id"=>"999", "all"=>"0"));
    if ($ret->sendresult->error)
        echo "Ошибка №".$ret->statusresult->error;
    else {
        echo $ret->statusresult->status, "\n";
        echo $ret->statusresult->last_date, "\n";
        echo $ret->statusresult->err, "\n";
    }
    }


    public function status_full()
    {
    // Расширенный статус
    
    $ret = $client->get_status(array("login"=>"alex", "psw"=>"123", "phone"=>"79999999999", "id"=>"999", "all"=>"2"));
    if ($ret->sendresult->error)
        echo "Ошибка №".$ret->statusresult->error;
    else {
        echo $ret->statusresult->status, "\n";
        echo $ret->statusresult->last_date, "\n";
        echo $ret->statusresult->err, "\n";
        echo $ret->statusresult->last_timestamp, "\n";
        echo $ret->statusresult->send_date, "\n";
        echo $ret->statusresult->send_timestamp, "\n";
        echo $ret->statusresult->phone, "\n";
        echo $ret->statusresult->cost, "\n";
        echo $ret->statusresult->sender_id, "\n";
        echo $ret->statusresult->status_name, "\n";
        echo $ret->statusresult->message, "\n";
        echo $ret->statusresult->operator, "\n";
        echo $ret->statusresult->region, "\n";
    }
    
    }

    public function balance()
    {
        // Проверка баланса
        $data = $this->config;
        
        $soap = $this->client->get_balance($data);
        //print_r($soap);
        $result = $soap->balanceresult;
        if ($result->error)
        {
            echo t('sms.api.balance.'.$result->error);
            return FALSE;
        }
        else
        {
            echo $result->balance;
            return $result->balance;
        }
    }
    
    public function check_balance()
    {
            
        if ($balanse = $this->balance())
        {
            /**
            * Min balance
            */
            $min_balanse = 50;
            if($balanse < $min_balanse)
            {
                /**
                * Отправить письмо админу о балансе
                */
                $admin = ORM::factory('user', array('login' => 'admin'));
                $this->send($admin->phone, 'min_balanse', array('balance' => $balanse));
    
                ORM::factory('log')->add_action(NULL, 'min_balance_SMS', NULL ,'min_balance_SMS = '.$balanse);
            }
        } 
    }
}
?>