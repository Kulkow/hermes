<?php defined('SYSPATH') or die('No direct script access.');

class Slider{

    public static function render($type = NULL)
    {
        $sliders = ORM::factory('slider')->find_all();
        
        echo View::factory('slider/view')->bind('sliders', $sliders)->bind('type',$type);
    }
}