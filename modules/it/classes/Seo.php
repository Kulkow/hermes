<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * SEO
 */
class SEO
{
	/**
	 * Обрезка текстовой строки
	 */
	static public function limit_chars($model, $value, $source, $limit, $end_char = '', $preserve_words = TRUE)
	{
		if (empty($value))
		{
			$value = Text::limit_chars($model->$source, $limit, $end_char, $preserve_words);
		}
		return $value;
	}

	/**
	 * Траслитерация
	 */
	static public function translit($model, $value, $source)
	{
		if (empty($value))
		{
			$value = Text::translit($model->$source);
		}
		return $value;
	}

	/**
	 * Загрузка типографа с указанной конфигурацией
	 */
	static public function jevix($config = NULL)
	{
		if ($config === NULL)
		{
			$config = 'guest';

			if ($user = Auth::user())
			{
				if ($user->roles->has('admin'))
				{
					$config = 'admin';
				}
				else
				{
					$config = 'user';
				}
			}
		}

		return Jevix::instance($config);
	}

	/**
	 * Простой парсинг текста, конфигурация типографа выбирается в зависимости от текущего пользователя
	 */
	static public function parse($value)
	{
		return SEO::jevix()->parse($value);
	}

	static public function format(ODM $model, $value)
	{
		if ($value)
		{
			$model->announce = SEO::cut($value);
			$model->content = SEO::jevix()->parse($value);

			if ( ! $model->description)
			{
				$model->description = HTML::strip_tags($model->announce);
			}
    	}

		return $value;
	}

	public static function cut($text, $min = 250, $max = 500)
	{
		$cut = '<!--break-->';

		if ($pos = UTF8::strpos($text, $cut))
		{
			$announce = UTF8::substr($text, 0, $pos);
			$length = UTF8::strlen(HTML::strip_tags($announce));
			if ($min <= $length AND $length <= $max)
			{
				return SEO::jevix()->parse($announce);
			}
		}
		return SEO::jevix()->parse(SEO::autocut(str_replace($cut, '', $text), $max));
	}

	public static function autocut($text, $limit = 250, $delimiter = "\s;,.!?:#")
	{
		$delimiter = str_replace("#", "\\#", $delimiter);

		$text = preg_replace_callback("#(</?[a-z]+(?:>|\s[^>]*>)|[^<]+)#mi", function($matches) use ($limit, $delimiter)
		{
			static $length = NULL;

   			if ($length === NULL)
   			{
   				$length = $limit;
   			}
			$length1 = $length - 1;

			if ('<' == $matches[0][0])
			{
				return $matches[0];
			}

			if ($length <= 0)
			{
				return '';
			}

			$result = Text::limit_chars($matches[0], $length, '', TRUE);
			$length -= UTF8::strlen($result) + 1;
			return $result;

		}, $text);

		while (preg_match("#<([a-z]+)[^>]*>\s*</\\1>#mi", $text))
		{
			$text = preg_replace("#<([a-z]+)[^>]*>\s*</\\1>#mi", '', $text);
		}

		return $text;
	}


	static public function normalize_tags($value)
	{
		$tags = explode(',', trim(HTML::strip_tags((string)$value), "\r\n\t\0\x0B ."));
		$tags_new = $tags_low = array();
		foreach ($tags as $tag)
		{
			$tag = trim($tag, "\r\n\t\0\x0B .");
			if (UTF8::strlen($tag) > 1)
			{
				$low = UTF8::strtolower($tag);
				if ( ! in_array($low, $tags_low))
				{
					$tags_new[] = $tag;
					$tags_low[] = $low;
				}
			}
		}

		if (count($tags_new) > 10)
		{
			$tags_new = array_slice($tags_new, 0, 10);
		}

		return implode(', ', $tags_new);
	}

} // End SEO