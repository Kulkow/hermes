<?php defined('SYSPATH') or die('No direct script access.');
/**
 Визуальный редактор
 */
class  Wysiwyg
{
    
    public static function params($user = 'user', $class = 'it-area', $type = 'full',  $editor = 'tinymce')
    {
        $config = Kohana::$config->load('wysiwyg')->get($editor);
        $params = array( 'path' => $config['path'],
                        'params' => array(),
                );
        if (empty($config['params'][$user][$type]))
        {
            return FALSE;
        }
                
        $set = array_merge($config['params']['default'],$config['params'][$user][$type]);
        if ($editor == 'tinymce')
        {
            $set['editor_selector'] = $class;
        }
        $params['params'] = json_encode($set);
        return $params;
    }
}