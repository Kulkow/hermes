<?php defined('SYSPATH') or die('No direct script access.');

class Validation extends Kohana_Validation
{
	public function errors($file = NULL, $translate = TRUE)
	{
		if ($file === NULL)
		{
			// Return the error list
			return $this->_errors;
		}

		// Create a new message list
		$messages = array();

		foreach ($this->_errors as $field => $set)
		{
			list($error, $params) = $set;

			$values = array();

			if ($params)
			{
				foreach ($params as $key => $value)
				{
					if (is_array($value))
					{
						// All values must be strings
						$value = implode(', ', Arr::flatten($value));
					}
					elseif (is_object($value))
					{
						// Objects cannot be used in message files
						continue;
					}

					// Add each parameter as a numbered value, starting from 1
					$values[':param'.($key + 1)] = $value;
				}
			}

			if ( ! $message = Kohana::message($file, "{$field}.{$error}"))
			{
				if (FALSE !== ($pos = strpos($file, '/')))
				{
					$file = substr($file, 0, $pos);
				}
				$message = "{$file}.{$field}.{$error}";
			}
			$messages[$field] = t($message, $values);
		}
		return $messages;
	}

}
