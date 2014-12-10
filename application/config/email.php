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
/*
return array(
	'default'	=> array(
		'from'		=> 'robot@[domain]',
		'subject'	=> 'Письмо с сайта http://[domain] &laquo;[title]&raquo;',
	),
	'auth'		=> array(
		'registr'	=> 'Регистрация на сайте &laquo;[title]&raquo; (http://[domain])',
		'activate'	=> 'Активация аккаунта на сайте &laquo;[title]&raquo; (http://[domain])',
		'forgot'	=> 'Восстановление пароля на сайте &laquo;[title]&raquo; (http://[domain])',
		'confirm'	=> 'Ваш новый пароль на сайте &laquo;[title]&raquo; (http://[domain])',
	),
);*/

return array(
	'default'	=> array(
		'from'		=> 'admin@fin-hermes.ru',
		'subject'	=> 'Письмо с сайта http://fin-hermes.ru Hermes',
	),
	'auth'		=> array(
		'registr'	=> 'Регистрация на сайте Hermes (http://fin-hermes.ru)',
		'activate'	=> 'Активация аккаунта на сайте Hermes (http://fin-hermes.ru)',
		'forgot'	=> 'Восстановление пароля на сайте Hermes (http://fin-hermes.ru)',
		'confirm'	=> 'Ваш новый пароль на сайте Hermes (http://fin-hermes.ru)',
	),
);