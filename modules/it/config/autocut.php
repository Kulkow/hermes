<?php defined('SYSPATH') OR die('No direct access allowed.');

return array( 'config' => array(
                         'length_before_cut' => 250,
                         'TagUnbreakable' =>  array('video','code','a','blockquote'),
                         'cutPersonal' =>  TRUE,
                         'cutAdmin' =>  TRUE,
                         'LightModeOn' =>  false,
                         'SecondBarrier' =>  500
                         ),
);
/*
$config['TagUnbreakable']=array('video','code','a','blockquote');

/*
 * Do you want to cut topics in personal blogs as well?
 * В персональных блогах топики резать будем?
 */


/*
 * Should we cut text for topics by admin?
 * Топики администратора тоже урезать?
 */

/*
 * If LightModeOn is set "true" then IF user had put the <cut> into text autocutting check SecondBarrier.
 * Otherways AutoCut will override user's cut IF user's cut is AFTER the length_before_cut value.
 * Если включить опцию ниже, то ЕСЛИ полбователь поставил <cut>, АвтоКат установит другой лимит: SecondBarrier.
 * Иначе, пользовательский кат будет заменен автоматическим ЕСЛИ он был установлен ПОСЛЕ лимита (length_before_cut).
 */

/* 
 * Add an other text length check if LightModeOn. set 0 if you accept ANY length before user's manual cut;
 * Вторая проверка (при LightModeOn). Установите 0, если пользователь может поставить КАТ в ЛЮБОМ месте, или установите второе разумное ограничение;
 */

