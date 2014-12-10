<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * User authorization library. Handles user login and logout, as well as secure
 * password hashing.
 */
class Kohana_Auth
{


    /**
	 * Check if there is an active session. Optionally allows checking for a
	 * specific role.
	 *
	 * @param   string   role name
	 * @return  mixed
	 */
	public function logged_in($role = NULL)
	{
		return Auth::instance()->_logged_in($role);
	}

	/**
	 * Gets the currently logged in user from the session (with auto_login check).
	 * Returns FALSE if no user is currently logged in.
	 *
	 * @return  mixed
	 */
	public static function user()
	{
		return Auth::instance()->_user();
	}



	/**
	 * Attempt to log in a user by using an ORM object and plain-text password.
	 *
	 * @param   string   username to log in
	 * @param   string   password to check against
	 * @param   boolean  enable autologin
	 * @return  boolean
	 */
	public static function login($username, $password, $remember = FALSE)
	{
		if (empty($password))
		{
			return FALSE;
        }
		return Auth::instance()->_login($username, $password, $remember);
	}

	public static function force_login($user)
	{
		if ( ! $user instanceof ODM)
		{
			$user = ODM::factory('user', $user);
		}
		Auth::instance()->_complete_login($user);
	}

	/**
	 * Log a user out and remove any autologin cookies.
	 *
	 * @param   boolean  completely destroy the session
	 * @param	boolean  remove all tokens for user
	 * @return  boolean
	 */
	public static function logout($destroy = FALSE, $logout_all = FALSE)
	{
		return Auth::instance()->_logout($destroy, $logout_all);
	}

	/**
	 * Perform a hmac hash, using the configured method.
	 *
	 * @param   string  string to hash
	 * @return  string
	 */
	public static function hash($str)
	{
		return Auth::instance()->_hash($str);
	}


	// Auth instance
	protected static $_instance;

	/**
	 * Singleton pattern
	 *
	 * @return Auth
	 */
	public static function instance()
	{
		if ( ! isset(Auth::$_instance))
		{
			Auth::$_instance = new Auth();
		}

		return Auth::$_instance;
	}

	protected $_session;

	protected $_config;

	/**
	 * Loads Session and configuration options.
	 *
	 * @return  void
	 */
	protected function __construct()
	{
		// Save the config in the object
		$this->_config = Kohana::$config->load('auth');

		$this->_session = Session::instance($this->_config['session']);
	}

	/**
	 * Checks if a session is active.
	 *
	 * @param   mixed    $role Role name string, role ODM object, or array with role names
	 * @return  boolean
	 */
	protected function _logged_in($role = NULL)
	{
		// Get the user from the session
		if ( ! $user = $this->_user())
		{
			return FALSE;
		}

		if ($user instanceof Model_User AND $user->loaded())
		{
			// If we don't have a roll no further checking is needed
			if ( ! $role)
			{
				return TRUE;
			}

			return $user->roles->has($role);
		}

		return FALSE;
	}

	/**
	 * Gets the currently logged in user from the session (with auto_login check).
	 * Returns FALSE if no user is currently logged in.
	 *
	 * @return  mixed
	 */
	protected function _user()
	{
		if ( ! $user = $this->_session->get($this->_config['key']))
		{
			// check for "remembered" login
			$user = $this->_auto_login();
		}

		if ($user AND ! $user instanceof ODM)
		{
			$user = ODM::factory('user', $user);
		}


		return $user;
	}

	/**
	 * Logs a user in.
	 *
	 * @param   string   username
	 * @param   string   password
	 * @param   boolean  enable autologin
	 * @return  boolean
	 */
	protected function _login($user, $password, $remember)
	{
		if (is_string($user))
		{
			if (Valid::email($user))
			{
				$user = ODM::factory('user')->find(array('email' => $user));
			}
			else
			{
				$user = ODM::factory('user', $user);
			}
		}

		// If the passwords match
		if ($user->roles->has('login') AND $user->password === $this->hash($password))
		{
			if ($remember === TRUE)
			{
				// Create a new autologin token
				$token = ODM::factory('token')->create_new($user, $this->_config['lifetime']);

				// Set the autologin cookie
				Cookie::set($this->_config['key'], $token->token, $this->_config['lifetime']);
			}else {
				// Create a new autologin token
				$token = ODM::factory('token')->create_new($user, $this->_config['shorttime']);

				// Set the autologin cookie
				Cookie::set($this->_config['key'], $token->token, $this->_config['shorttime']);
			}

			// Finish the login
			$this->_complete_login($user);

			return TRUE;
		}
		// Login failed
		return FALSE;
	}

	/**
	 * Log out a user by removing the related session variables.
	 *
	 * @param   boolean  completely destroy the session
	 * @param   boolean  remove all tokens for user
	 * @return  boolean
	 */
	protected function _logout($destroy = FALSE, $logout_all = FALSE)
	{
		if ($token = Cookie::get($this->_config['key']))
		{
			// Delete the authkey cookie to prevent re-login
			Cookie::delete($this->_config['key']);

			$token = ODM::factory('token', $token);

			// Clear the authkey token from the database
			if ($token->loaded() AND $token->user->loaded())
			{
				if ($logout_all)
				{
					$token->remove(array('user' => $token->user->_id));
				}
				else
				{
					$token->delete();
				}
			}
		}

		if ($destroy === TRUE)
		{
			// Destroy the session completely
			$this->_session->destroy();
		}
		else
		{
			// Remove the user from the session
			$this->_session->delete($this->_config['key']);

			// Regenerate session_id
			$this->_session->regenerate();
		}

		// Double check
		return ! $this->_logged_in();
	}

	/**
	 * Logs a user in, based on the authkey cookie.
	 *
	 * @return  mixed
	 */
	protected function _auto_login()
	{
		if ($token = Cookie::get($this->_config['key']))
		{
			// Load the token and user
			$token = ODM::factory('token', $token);

			if ($token->loaded() AND $token->user->loaded())
			{
				if ($token->user_agent === sha1(Request::$user_agent))
				{
					// Save the token to create a new unique token
					$token->create_new($token->user, $this->_config['lifetime']);

					// Set the new token
					Cookie::set($this->_config['key'], $token->token, $this->_config['lifetime']);

					// Complete the login with the found data
					$this->_complete_login($token->user);

					// Automatic login was successful
					return $token->user;
				}
				// Token is invalid
				$token->delete();
			}
		}
		return FALSE;
	}

	protected function _complete_login($user)
	{
		// Regenerate session_id
		$this->_session->regenerate();

		// Store user in session
		$this->_session->set($this->_config['key'], $user->_id);

		return TRUE;
	}

	/**
	 * Perform a hmac hash, using the configured method.
	 *
	 * @param   string  string to hash
	 * @return  string
	 */
	protected function _hash($str)
	{
		return hash_hmac($this->_config['hash']['method'], $str, $this->_config['hash']['key']);
	}


    /**
	 * Compare password with original (hashed). Works for current (logged in) user
	 *
	 * @param   string  $password
	 * @return  boolean
	 */
	public function check_password($password)
	{
		$user = Auth::instance()->_user();

		if ( ! $user)
			return FALSE;

		return ($this->_hash($password) === $user->password);
	}

} // End Auth
