<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Общая информация о сайте (заголовок, меты), используется для СЕО
 */
class Model_Site extends Model
{
	protected $_config = NULL;

	public function __construct()
	{
		$this->_config = Kohana::$config->load('site');
	}

    /**
     * выставление сео-параметров
     */
	public function assign($title, $keywords = NULL, $description = NULL)
	{
		if ($title instanceof ORM)
		{
			return $this->assign($title->title, $title->keywords, $title->description);
		}

		if ( ! $this->title)
		{
			$this->title = $this->name;
		}

		$this->title = $title.$this->title_separator.$this->title;

		if ($keywords)
		{
			$this->keywords = $keywords;
		}

		if ($description)
		{
			$this->description = $description;
		}

		return $this;
	}

    /**
     * выставление сео-параметров
     */
	public function seo($title, $keywords = NULL, $description = NULL)
	{
		/*if ( ! $this->title)
		{
			$this->title = $this->name;
		}*/



		/*if ($title instanceof ORM)
		{
			$keywords = $title->keywords;
			$description = $title->description;
			$title = $title->title;
		}

		$this->title = $title.$this->title_separator.$this->title;

		if ($keywords)
		{
			$this->keywords = $keywords;
		}
		if ($description)
		{
			$this->description = $description;
		}
              */
		return $this;
	}


	public function __get($name)
	{
		return Arr::get($this->_config, $name);
	}

	public function __set($name, $value)
	{
		$this->_config[$name] = $value;
	}

	public function get($name, $default = NULL)
	{
		return Arr::get($this->_config, $name, $default);
	}
}