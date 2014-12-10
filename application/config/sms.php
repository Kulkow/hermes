<?php defined('SYSPATH') or die('No direct access allowed.');

return array
(
	'default' => array(
                "SMSC_LOGIN"       => "ip-test",
                "SMSC_PASSWORD"    => md5('ip-test'),
                "SMSC_POST"        => 0,
                "SMSC_HTTPS"       => 0,
                "SMSC_CHARSET"     => "utf-8",	
                "SMSC_DEBUG"       => 1,
                "SMTP_FROM"        => "api@smsc.ru"),
    'soap' => array(
                    //"login"       => "ip-test",
                   // "psw"         => md5('ip-test'),
                    "login"       => "rcc",
                    "psw"         => md5('sa-12345'),
                    //"psw"         => 'sa-12345',
                    "sender"      => 'RCC PENZA',
                    //"id"          => 1,
                    //'phone'       => 1,  
                   ),
);