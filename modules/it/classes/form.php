<?php defined('SYSPATH') or die('No direct script access.');

class Form extends Kohana_Form
{	public static function errors(array $errors = NULL, array $attributes = NULL)
	{		if ($count = count($errors))
		{			return '<div'.HTML::attributes($attributes).'>'.Text::declension('Обнаружена;Обнаружено', $count)				.' '.$count.' '.Text::declension('ошибка;ошибки;ошибок', $count).'</div>';
		}
		return '';	}

} // End Form