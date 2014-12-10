<?php defined('SYSPATH') or die('No direct script access.');

class Text extends Kohana_Text
{
	public static $translit_table = array(
		'а' => 'a', 	'А' => 'A',
		'б' => 'b', 	'Б' => 'B',
		'в' => 'v', 	'В' => 'V',
		'г' => 'g', 	'Г' => 'G',
		'д' => 'd', 	'Д' => 'D',
		'е' => 'e', 	'Е' => 'E',
		'ж' => 'zh',	'Ж' => 'Zh',
		'з' => 'z',		'З' => 'Z',
		'и' => 'i',		'И' => 'I',
		'й' => 'y',		'Й' => 'Y',
		'к' => 'k',		'К' => 'K',
		'л' => 'l',		'Л' => 'L',
		'м' => 'm',		'М' => 'M',
		'н' => 'n',		'Н' => 'N',
		'о' => 'o',		'О' => 'O',
		'п' => 'p',		'П' => 'P',
		'р' => 'r',		'Р' => 'R',
		'с' => 's',		'С' => 'S',
		'т' => 't',		'Т' => 'T',
		'у' => 'u',		'У' => 'U',
		'ф' => 'f',		'Ф' => 'F',
		'х' => 'h',		'Х' => 'H',
		'ц' => 'c',		'Ц' => 'C',
		'ч' => 'ch',	'Ч' => 'Ch',
		'ш' => 'sh',	'Ш' => 'Sh',
		'щ' => 'sch',	'Щ' => 'Sch',
		'ъ' => '',		'Ъ' => '',
		'ы' => 'y',		'Ы' => 'Y',
		'ь' => '',		'Ь' => '',
		'э' => 'e',		'Э' => 'E',
		'ю' => 'yu',	'Ю' => 'Yu',
		'я' => 'ya',	'Я' => 'Ya',
		'і' => 'i',		'І' => 'I',
		'ї' => 'yi',	'Ї' => 'Yi',
		'є' => 'e',		'Є' => 'E'
	);

	public static function translit($str)
	{
		$str = preg_replace('{[ |.]+}', '_', $str);
		$str = iconv('UTF-8', 'UTF-8//IGNORE', strtr($str, Text::$translit_table));
		return preg_replace(array('/[^0-9a-zA-Z_\-]+/', '{[_]+}', '{[-]+}'), array('', '_', '-'), $str);
	}

	public static function clean($str)
	{
		return preg_replace(array('/[^(\w)|(\x7F-\xFF)|(\s)|(\-)]/', '{[_]+}', '{[ ]+}', '{[\-]+}'), array('', '_', ' ', '-'), $str);
	}

	public static function declension($forms, $count, $lang = NULL)
	{
		if (is_string($forms))
		{
			$forms = array_map('trim', explode(';', $forms));
		}
		switch (count($forms))
		{
			case 1:
					$forms[1] = $forms[0];
			case 2:
					$forms[2] = $forms[1];
		}

		switch ($lang === NULL ? I18n::$lang : $lang)
		{
			case 'en-us':
					return $forms[$count == 1 ? 0 : 1];

			case 'ru-ru':
					$mod100 = $count % 100;
					switch ($count % 10)
					{
						case 1:
								return $forms[$mod100 == 11 ? 2 : 0];
						case 2:
						case 3:
						case 4:
								return $forms[(($mod100 > 10) AND ($mod100 < 20)) ? 2 : 1];
						case 5:
						case 6:
						case 7:
						case 8:
						case 9:
						case 0:
								return $forms[2];
					}

			default:
					return $forms[0];
		}
	}
    
    public static function pick($str, $type = 'phone', $lang = NULL)
	{
	   switch($type)
       {
           case 'phone':
           
               $length = Utf8::strlen($str);
               if($length > 6)
               {
                  $start = substr($str, 0, 2);
                  $end = substr($str, -3, 3);
                  $middle = str_repeat('X',$length - 5);
                  return $start.$middle.$end;
               }
               else
               {
                  $end = substr($str, -3, 3);
                  $start = str_repeat('X',$length - 3);
                  return $start.$end; 
               }
           break;
           
           case 'email':
            if(! Valid::email($str)) return FALSE;
            list($login, $domen) = explode('@',$str);
            $length = Utf8::strlen($login);
            if($length > 3)
            {
              $start = substr($login, 0, 3);
              $end = str_repeat('X',$length - 3);
              return $start.$end.'@'.$domen;
            }
            else
            {
               $end = str_repeat('X',$length);
               return $end.'@'.$domen; 
            }
            
           break;
       }
	}
    
}
