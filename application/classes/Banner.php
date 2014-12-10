<?php defined('SYSPATH') or die('No direct script access.');

class Banner{

    public static function render($type = NULL)
    {
        $banners = ORM::factory('banner')->find_all();
        
        echo View::factory('banner/view')->bind('banners', $banners)->bind('type',$type);
    }
}