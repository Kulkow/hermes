<?php defined('SYSPATH') or die('No direct script access.');

class Config_File extends Kohana_Config_File
{
	public function load($group)
	{
		$config = array();

		if ($files = Kohana::find_file($this->_directory, $group, NULL, TRUE))
		{
			foreach ($files as $file)
			{
				// Merge each file to the configuration array
				$config = Arr::merge($config, Kohana::load($file));
			}
		}

		$dir = $this->_directory;

		foreach (explode('-', I18n::$lang) as $lang)
		{
			$dir .= DIRECTORY_SEPARATOR.$lang;

			if ($files = Kohana::find_file($dir, $group, NULL, TRUE))
			{
				foreach ($files as $file)
				{
					// Merge each file to the configuration array
					$config = Arr::merge($config, Kohana::load($file));
				}
			}
		}

		return $config;
	}
}