<?php defined('SYSPATH') or die('No direct script access.');

class Perfectmoney{

    public static $protocol = 'https';
    
    protected $pm_member_id = NULL;
    protected $pm_password = NULL;
    protected $pm_signature = NULL;
    
    public $data = array();
    
    public $currency = 'USD';

    
    public static function factory($currency = 'USD'){
        $new = new Perfectmoney;
        $payment = ORM::factory('payment', array('alias' => 'perfect'));
        if(! $payment->loaded()){
            return FALSE;
        }
        $new->pm_member_id = $payment->login;
        $new->pm_password = $payment->password;
        $new->pm_signature = $payment->signature;
        $allowed_cur = array('USD', 'EUR');
        if($currency){
            if(in_array($currency,$allowed_cur)){
                $new->currency = $currency;   
            }
        }
        return $new;
    }
    
    public function params($bill = NULL)
    {
        if($bill instanceof ORM){
            
        }else{
            $bill = ORM::factory('bill', intval($bill));
        }
        if(! $bill->loaded()){
            return FALSE;
        }
        if(! $this->pm_member_id){
            return FALSE;
        }
        $order_id = $bill->id;
        $this->data['action'] = 'https://perfectmoney.is/api/step1.asp';

		$this->data['PAYEE_ACCOUNT'] = $this->pm_member_id;
		$this->data['PAYEE_NAME'] = 'Hermes';

        
		$this->data['PAYMENT_UNITS'] = $this->currency;

		$this->data['STATUS_URL'] = Site::url('perfectmoney/callback', NULL, self::$protocol);
		$this->data['PAYMENT_URL'] = Site::url('perfectmoney/success', NULL, self::$protocol);
		$this->data['PAYMENT_URL_METHOD'] = 'GET';
		$this->data['NOPAYMENT_URL'] = Site::url('perfectmoney/fail', NULL, self::$protocol);
		$this->data['NOPAYMENT_URL_METHOD'] = 'GET';
		$this->data['SUGGESTED_MEMO'] = 'Hermes'.' ('.$order_id.')';
		$this->data['PAYMENT_ID'] = $order_id;
		$this->data['PAYMENT_AMOUNT'] = $bill->summa;
        return $this;
    }
    
    public function bill($post = array()){
        if (Arr::get($post, 'PAYMENT_ID', NULL)) {
			$order_id = (int)Arr::get($post, 'PAYMENT_ID', NULL);
		} else {
            return FALSE;
		}
        $bill = ORM::factory('bill', $order_id);
        if(! $bill->loaded()){
            return FALSE;
        }
        return $bill;
    }    
    
    public function check($post = array()){
        if (Arr::get($post, 'PAYMENT_ID', NULL)) {
			$order_id = (int)Arr::get($post, 'PAYMENT_ID', NULL);
		} else {
            $auth_user = Auth::instance()->get_user();
            ORM::factory('log')->add_action($auth_user, 'bad perfect money callback');
            return;
		}
        $bill = ORM::factory('bill', $order_id);
        if(! $bill->loaded()){
            return FALSE;
        }
        $string = Arr::get($post,'PAYMENT_ID').':'.Arr::get($post,'PAYEE_ACCOUNT').':'.
               Arr::get($post,'PAYMENT_AMOUNT').':'.Arr::get($post,'PAYMENT_UNITS').':'.
               Arr::get($post,'PAYMENT_BATCH_NUM').':'.Arr::get($post,'PAYER_ACCOUNT').':'.
               strtoupper(md5($this->pm_signature)).':'.Arr::get($post,'TIMESTAMPGMT');
		$hash=strtoupper(md5($string));
        
        /*
        echo Arr::get($post,'V2_HASH').'<br />';
        echo $string.'<br />';
        echo $hash.'<br />';
        */

		if($hash==Arr::get($post,'V2_HASH')){ 
		  // proccessing payment if only hash is valid
		   if(Arr::get($post,'PAYMENT_AMOUNT')==$bill->summa  && Arr::get($post,'PAYEE_ACCOUNT')==$this->pm_member_id && Arr::get($post,'PAYMENT_UNITS')==$bill->currency->code){
                return TRUE;
		   }else{
		      //print_r($post);
              /*
              if(PERFECTMONEY_DEBUG_STATUS_URL==1) $this->log->write("IP: {$_SERVER['REMOTE_ADDR']}; ERROR REASON: fake data; POST: ".serialize($this->request->post)."; STRING: $string; HASH: $hash\n".
			  '	IN AMOUNT: '.$this->request->post['PAYMENT_AMOUNT'].' and ORDER AMOUNT: '.$this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false)."\n".
			  '	IN ACCOUNT: '.$this->request->post['PAYEE_ACCOUNT'].' and ORDER ACCOUNT: '.$this->config->get('perfectmoney_merchant')."\n".
			  '	IN UNITS:'.$this->request->post['PAYMENT_UNITS'].' and ORDER UNITS: '.$order_info['currency_code']."\n");
              */
              return FALSE;
		   }
		}else{ // you can also save invalid payments for debug purposes
		   return FALSE;
           //if(PERFECTMONEY_DEBUG_STATUS_URL==1) $this->log->write("IP: {$_SERVER['REMOTE_ADDR']}; ERROR REASON: bad hash; POST: ".serialize($this->request->post)."; STRING: $string; HASH: $hash\n");
		}
    } 
}