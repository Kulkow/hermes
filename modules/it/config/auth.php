<?php defined('SYSPATH') or die('No direct access allowed.');

return array(
	'hash'		=> array(
		'method'	=> 'sha256',
		'key'		=> 'Auth hash key',
	),
	'lifetime' 	=> 1209600,
	'session' 	=> Session::$default,
	'key'  		=> 'auth_user',
	'shorttime'	=> 259200, // 3 days
);
