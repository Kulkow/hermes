<?php defined('SYSPATH') or die('No direct script access.');
 
/**
 * Пересчитываем
 *
 * @author biakaveron
 * php index.php --task=Welcome
 * 
 * php /var/www/u0034415/data/www/dev.fin-hermes.ru/index.php --task=Welcome
 * php /var/www/u0034415/data/www/dev.fin-hermes.ru/index.php --task=Summary

 */
class Task_Summary extends Minion_Task {
 
	protected $_options = array(
		// param name => default value
		'foo'   => 'beautiful',
	);
 
	/**
	 * Test action
	 *
	 * @param array $params
	 * @return void
	 */
	protected function _execute(array $params)
	{
		$day = date('w');
        $allow_day = 1;
        if($day == $allow_day){ // Только в понедельник
            $cards = ORM::factory('card')->where('active','=','1')->find_all(); // Выбираем активные карты
            $count = $i = 0;
            $time = time();
            foreach($cards as $card){
                $income = $card->summary_income(TRUE, TRUE);
                if(! empty($income['value'])){
                    $event = ORM::factory('event')->add_event($card, 'add_cron', array('ball' => $income['value']));
                    if($event->loaded()){
                        $card->last_event = $event->id;
                    }
                    $card->ball += $income['value'];
                    if($card->active_time <= $time){
                       $card->active = 0; 
                    }else{
                        $card->start_time = time();
                    }
                    $card->update();
                    $i++;  
                }
                $count++;
            }
             // Еще бы логи вести
             $content = 'card count: '.$count.'- '.$i;
             ORM::factory('log')->add_action(NULL, 'cron', NULL, $content);
             Minion_CLI::write('card count: '.$count.'- '.$i);
        }else{
            //$content = 'no day count: '.$allow_day.'- '.$day;
            //ORM::factory('log')->add_action(NULL, 'cron', NULL, $content);
            Minion_CLI::write('no day count: '.$allow_day.'- '.$day);
        }
        
	}
 
}