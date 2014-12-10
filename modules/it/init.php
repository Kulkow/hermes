<?php defined('SYSPATH') or die('No direct script access.');

//set_exception_handler(array('Site', 'Exception_handler'));

/**
 * Admin panel
 */
 /*
Route::set('admin', 'admin(/<controller>(/page<page>)(/<action>(/<id>)))')
	->defaults(array(
		'directory'		=> 'admin',
		'controller'	=> 'layout',
		'action'		=> 'index',
	));*/

/**
 * Auth routes
 */
Route::set('auth', '<action>(/<token>)', array('action' => '(?:login|registr|activate|forgot|confirm|cancel)'))
	->defaults(array(
		'controller' 	=> 'Auth',
	));

/**
 * Logout controller
 */
Route::set('logout', 'logout')
	->defaults(array(
		'controller' 	=> 'logout',
	));
