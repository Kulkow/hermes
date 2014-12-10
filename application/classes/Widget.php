<?php defined('SYSPATH') or die('No direct script access.');
class Widget
{
    public static function render($name = NULL, $params = array())
    {
        if($name)
        {
            if(empty($params))
            {
                $params = array('css', 'js');
            }
            echo View::factory('widget/'.$name.'/view')->bind('params', $params)->bind('name', $name);
        }
    }
}