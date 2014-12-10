<?php defined('SYSPATH') OR die('No direct script access.');

abstract class HTTP_Exception extends Kohana_HTTP_Exception {

 public function get_template($content = NULL)
 {
    $auth_user = Auth::instance()->get_user();
    $site = Model::factory('site');
    $menu = NULL;
	$template = View::factory('layout');
	$template->bind_global('site', $site);
    $template->bind_global('menu', $menu);
	$template->bind_global('auth_user', $auth_user);
	$template->content = $content;
	$template->sidebar = NULL;
    
    return $template;
 } 	

} // End HTTP_Exception