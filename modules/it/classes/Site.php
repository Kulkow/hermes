<?php defined('SYSPATH') or die('No direct script access.');

class Site
{
	public static function ssl()
    {
        /**
         *  ## anything else redirect to https
            RewriteCond %{SERVER_PORT} 80 
            RewriteRule ^(.*)$ https://my.server.com/$1 [R,L]
        */
        
        /*if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "") {
            $redirect = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            Controller::redirect($redirect, 301);
        }*/
    }
    
    public static function url($uri = '', $query = NULL, $protocol = NULL, $use_get = FALSE)
	{
		return URL::site($uri, $protocol, Kohana::$index_file).URL::query($query, $use_get);
	}
    

	/**
	 * HTTP exceptions
	 */
	public static function exception_handler(Exception $e)
	{
        switch ($class = get_class($e))
        {
			case 'HTTP_Exception_401':
			case 'HTTP_Exception_403':
            case 'HTTP_Exception_404':
			       	echo Request::factory('error?status='.str_replace('HTTP_Exception_', '', $class))->execute()->body();
	        	break;

            default:
                	if (Kohana::$environment == Kohana::DEVELOPMENT)
                	{
                    	return Kohana_Exception::handler($e);
                	}
                    Response::factory()->status(500)->send_headers();
        }

       	exit();
	}

	/**
	 * Send email
	 */
	public static function email($to, $dir, $view, array $params = NULL)
	{
		$config = Kohana::$config->load('email');

		if ($config->enabled)
		{
			$from = Arr::path($config, 'default.from', 'mail@site.ru');
			if ($subject = Arr::path($config, $dir.'.'.$view))
			{
				if (is_array($subject))
				{
					extract($subject, EXTR_OVERWRITE);
				}
			}
			else
			{
				$subject = Arr::path($config, 'default.subject');
			}

			$parts = explode('-', I18n::$lang);

			do
			{
				// Create a path for this set of parts
				$path = $dir.DIRECTORY_SEPARATOR.'email'.DIRECTORY_SEPARATOR.implode(DIRECTORY_SEPARATOR, $parts);

				if (Kohana::find_file('views', $path.DIRECTORY_SEPARATOR.$view))
				{
					return Email::send($to, $from, $subject, View::factory($path.DIRECTORY_SEPARATOR.$view, $params)->render(), TRUE);
				}
				// Remove the last part
				array_pop($parts);
			}
			while ($parts);
		}
		return FALSE;
	}
    

	/**
	 * @var  array  cache of loaded languages
	 */
	protected $_i18n = array();

	/**
	 * Returns translation of a string. If no translation exists, the original
	 * string will be returned. No parameters are replaced.
	 *
	 *     $hello = Site::translate('Hello friends, my name is :name', 'site', 'en-us');
	 *
	 * @param   string   text to translate
	 * @param   string   text group
	 * @param   string   target language
	 * @return  string
	 */
	public static function translate($string, $group, $lang)
	{
		if (isset($_i18n[$group][$lang]))
		{
			$table = $_i18n[$group][$lang];
		}
		else
		{
			$table = array();

			// Split the language: language, region, locale, etc
			$parts = explode('-', $lang);

			do
			{
				// Create a path for this set of parts
				$path = implode(DIRECTORY_SEPARATOR, $parts).DIRECTORY_SEPARATOR.$group;

				if ($files = Kohana::find_file('i18n', $path, NULL, TRUE))
				{
					$t = array();
					foreach ($files as $file)
					{
						// Merge the language strings into the sub table
						$t = array_merge($t, Kohana::load($file));
					}

					// Append the sub table, preventing less specific language
					// files from overloading more specific files
					$table += $t;
				}

				// Remove the last part
				array_pop($parts);
			}
			while ($parts);

			$_i18n[$group][$lang] = $table;
		}
		return isset($table[$string]) ? $table[$string] : $string;
	}
    
    public  static function ini()
    {
    	return FALSE;
    }
}

function t($string, array $values = NULL, $lang = NULL)
{
	if (strpos($string, '.') !== FALSE)
	{
		list($group, $string) = explode('.', $string, 2);
	}
	else
	{
		$group = 'site';
	}
	$string = Site::translate($string, $group, $lang ? $lang : I18n::$lang);
	return empty($values) ? $string : strtr($string, $values);
}
