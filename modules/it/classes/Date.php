<?php defined('SYSPATH') or die('No direct script access.');

class Date extends Kohana_Date
{
	public static function format($timestamp, $format = NULL)
	{
        $format = $format ? $format : 'j F Y, H:i:s';
        if (strpos($format, 'F'))
        {
        	$month = date("F", $timestamp);
        	$format = preg_replace("~(?<!\\\\)F~U", preg_replace('~(\w{1})~u','\\\${1}', t('date.'.$month)), $format);
        }
        return date($format, $timestamp);
	}
}
