<?php defined('SYSPATH') or die('No direct script access.');

class Model_Check extends ORM {

    protected $_table_name = 'checks';

    public function clear_tresh($card = NULL)
	{
	   if(! $card)
       {
           return FALSE;
       }
       
       if(TRUE)
       {
           $delete = DB::query(Database::DELETE, 'DELETE FROM `'.$this->_table_name.'` WHERE `card`=:card')->bind(':card', $card);
           $delete->execute();
       }
	}

}