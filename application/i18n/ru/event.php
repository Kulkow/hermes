<?php defined('SYSPATH') or die('No direct access allowed.');

return array(
	'event'						    => 'операции с бонусной картой',
	
    'null'					        => 'операций не проводилось',
    
    'code'							=> 'Код трансакции',
	'code.not_empty'				=> 'Код трансакции не может быть пустым',
    'code.unique'			    	=> 'Код трансакции должен быть уникальным',
    
    'hash.not_empty'		        => 'Хеш не может быть пустым',
    'hash.Firefall::check_hash'		=> 'Хеш не верен проверьте данные',
    
    'card_id.check_card'            => 'Укажите действующий номер карты карта с таким номером не найдена',
    'card_id.not_empty'            => 'Укажите номер карты',
    
    );