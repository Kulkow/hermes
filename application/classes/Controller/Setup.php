<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Setup extends Controller_Layout
{
	function action_index()
    {
        echo 'SETUP';
        /*try
        {
        $user = ORM::factory('user')->values(array('login' => 'admin', 'email' => 'scorp1785@mail.ru', 'password' => '111777', 'phone' => '207340'));
        $user->created = time();
        $user->create();
        $user->add('roles', ORM::factory('role', array('name' => 'login')));
        $user->add('roles', ORM::factory('role', array('name' => 'admin')));
        }
        catch (ORM_Validation_Exception $e)
            {
    			$errors = $e->errors('page');
                print_r($errors);
            }
            */
    }
}    