<?php defined('SYSPATH') or die('No direct script access.');




/**
 * Админка
 */
Route::set('admin4', 'admin/event(/<controller>(/page<page>))')
	->defaults(array(
		'directory'		=> 'admin/Event',
		'controller'	=> 'event_type',
		'action'		=> 'index',
	));

Route::set('admin3', 'admin/event(/<controller>(/<action>(/<id>))(/page<page>))')
	->defaults(array(
		'directory'		=> 'admin/Event',
		'controller'	=> 'type',
		'action'		=> 'index',
	));

Route::set('admin1', 'admin(/<controller>(/page<page>))')
	->defaults(array(
		'directory'		=> 'admin',
		'controller'	=> 'layout',
		'action'		=> 'index',
	));
    
Route::set('admin2', 'admin(/<controller>(/<action>(/<id>))(/page<page>))')
	->defaults(array(
		'directory'		=> 'admin',
		'controller'	=> 'layout',
		'action'		=> 'index',
	));

/**
 * Статические страницы
 */
Route::set('page', '<alias>.html')
	->defaults(array(
		'controller' 	=> 'page',
		'action' 		=> 'view',
	));


/** Новости */
Route::set('news', 'news(/<id>(/<action>)(/page<page>))')
	->defaults(array(
		'controller' 	=> 'news',
		'action'     	=> 'index',
	));


/** tarif */
Route::set('tarif', 'tarif(/<id>(/<action>)(/page<page>))')
	->defaults(array(
		'controller' 	=> 'tarif',
		'action'     	=> 'index',
	));
/**
 * Элементы
 */
Route::set('item', '<controller>/<alias>.html')
	->defaults(array(
		'action' 		=> 'view',
	));

/**
 * Пользователи
 */
Route::set('user', 'user(/<id>(/<action>)(/page<page>))')
	->defaults(array(
		'controller' 	=> 'user',
		'action'     	=> 'index',
	));

/**
 * money
 */
Route::set('money', 'money(/<action>(/<type>))')
	->defaults(array(
        'controller' 	=> 'money',
		'action'     	=> 'index',
	));

    
/**
 * Списки
 */
//Route::set('list', '<controller>(/page<page>)(/<alias>)', array('page' => '/[0-9]+/'));
Route::set('list', '<controller>(/page<page>)', array('page' => '/[0-9]+/'));


/**
 * Общий
 */
Route::set('default', '(<controller>(/<action>(/<id>)))')
	->defaults(array(
		'controller' 	=> 'index',
		'action'     	=> 'index',
	));
