<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Perfectmoney extends Controller_Layout
{
	public function before(){
       parent::before();
	}
    
    public function action_view()
	{
		
	}
    
    public function action_success()
	{
	    $perfectmoney = Perfectmoney::factory();
        //$post = $this->request->post();
        $post = $_GET;
        if($perfectmoney->check($post)){
            $bill = $perfectmoney->bill($post);
            if($bill->status == 0){
                $bill->status = 1; // 
                $bill->update();
                $card = $bill->card;
                $card->calc($bill->summa,$bill->currency , 1, 'perfect');
                //$card->ball = $card->ball + $bill->summa;
                /** событие начисления */
                /*$event = ORM::factory('event')->add_event($card, 'add_perfect', array('ball' => $bill->summa));
                if($event->loaded()){
                    $card->last_event = $event->id;
                }*/
                $card->calc_tarif(); //пересчитаем тариф
                $card->save();
                if($this->auth_user){
                    Controller::redirect($this->auth_user->url());    
                }
                Controller::redirect('/');    
            }else{
                echo 'error';
            }
            
        }else{
            echo 'Error';
            exit();
        }
	}
    
    public function action_fail()
	{
	    $perfectmoney = Perfectmoney::factory();
        $post = $this->request->post();
        $data = array();
        $data['PAYEE_ACCOUNT'] = Arr::get($_GET,'PAYEE_ACCOUNT', NULL);
        $data['PAYMENT_AMOUNT'] = Arr::get($_GET,'PAYMENT_AMOUNT',NULL);
        $data['PAYMENT_UNITS'] = Arr::get($_GET,'PAYMENT_UNITS', NULL);
        $data['PAYMENT_ID'] = Arr::get($_GET,'PAYMENT_ID', NULL);
        //PAYEE_ACCOUNT=U7914933&PAYMENT_AMOUNT=51&PAYMENT_UNITS=USD&PAYMENT_ID=1
        $bill = $perfectmoney->bill($data);
        if($bill){
            if($bill->loaded()){
                if($bill->summa == $data['PAYMENT_AMOUNT'] AND $bill->currency->code == $data['PAYMENT_UNITS']){
                    $bill->status = 2;
                    $bill->update();
                    $this->template->content = 'Платеж отменен';
                }
            }
        }
    }    
    
    
}