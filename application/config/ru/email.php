<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * 	'group' => array(
 *		'template1'	=> 'Subject fo template1',
 *		'template2'	=> array(
 *			'from'	  => array('mail@domain.ru', 'Name'),
 *			'subject' => 'Subject fo template2',
 *		),
 *	),
 */

$domain = rtrim(URL::base(TRUE), '/');

return array(
	'default'	=> array(
		'from'		=> array(str_replace('http://', 'no-reply@', $domain), 'ТИНТЕРРА'),
		'subject'	=> 'Письмо с сайта '.$domain.' ТинТерра',
	),
	'auth'		=> array(
		'registr'	=> 'Регистрация на сайте '.$domain.' ТИНТЕРРА',
		'activate'	=> 'Активация аккаунта на сайте '.$domain.' ТИНТЕРРА',
		'forgot'	=> 'Восстановление пароля на сайте '.$domain.' ТИНТЕРРА',
		'confirm'	=> 'Ваш новый пароль на сайте '.$domain.' ТИНТЕРРА',
	),
	'user/friends'	=> array(
		'request'	=> 'Вас пригласили в друзья',
	),
	'user/invite_to'	=> array(
		'club'		=> 'Вас пригласили вступить в клуб',
		'event'		=> 'Вас пригласили принять учатие в мероприятии',
	),
);
