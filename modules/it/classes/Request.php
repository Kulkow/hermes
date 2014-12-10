<?php defined('SYSPATH') or die('No direct script access.');

class Request extends Kohana_Request
{
	public static function put($url, array $data = array())
	{
		$data['auth_user'] = ($user = Auth::user()) ? $user->login : FALSE;
		$data['token'] = Security::token();
		$data['SID'] = Session::instance()->id();

		$request = Request::factory($url);
		$request->method(HTTP_Request::PUT);
		$request->post(array_merge($data, Request::$current->post()));

		return $request->execute()->body();
	}

	public static function forward($url, array $data = array())
	{
		$data['auth_user'] = ($user = Auth::user()) ? $user->login : FALSE;
		$data['token'] = Security::token();
		$data['SID'] = Session::instance()->id();

		$request = Request::factory($url);
		$request->method(HTTP_Request::POST);
		$request->post(array_merge($data, Request::$current->post()));

		return $request->execute()->body();
	}

	public static function get_list($url)
	{
		$object = (object) unserialize(Request::forward('list/'.$url));
		return $object;
	}

	public static function parse_uri($uri)
	{
		$uri = parse_url($uri, PHP_URL_PATH);

		// Get the path from the base URL, including the index file
		$base_url = parse_url(Kohana::$base_url, PHP_URL_PATH);

		if (strpos($uri, $base_url) === 0)
		{
			// Remove the base URL from the URI
			$uri = (string) substr($uri, strlen($base_url));
		}

		if (Kohana::$index_file AND strpos($uri, Kohana::$index_file) === 0)
		{
			// Remove the index file from the URI
			$uri = (string) substr($uri, strlen(Kohana::$index_file));
		}

		return Request::process_uri($uri);
	}

} // End Request