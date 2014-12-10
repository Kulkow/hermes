<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Default auth user token
 */
class Model_Auth_User_Token extends ODM
{
	protected $_id_alias = 'token';

	protected $_belongs_to = array(
		'user' 		=> array(
			'model'		=> 'user'
		),
	);

	/**
	 * Handles garbage collection and deleting of expired objects.
	 *
	 * @return  void
	 */
	public function __construct($_id = NULL)
	{
		parent::__construct($_id);

		if (mt_rand(1, 100) === 1)
		{
			// Do garbage collection
			$this->delete_expired();
		}

		if ($this->_loaded AND $this->expires->sec < time())
		{
			// This object has expired
			$this->delete();
		}
	}

	/**
	 * Deletes all expired tokens.
	 *
	 * @return  ODM
	 */
	public function delete_expired()
	{
		$this->remove(array('expires' => array('$lte' => new MongoDate(time()))));
		return $this;
	}

	public function create_new($user, $lifetime, array $values = NULL)
	{
		if ($this->_loaded)
		{
			$this->delete();
		}

		$this->user = $user;
		$this->expires = new MongoDate(time() + $lifetime);
		$this->user_agent = sha1(Request::$user_agent);

		if ($values !== NULL)
		{
			$this->values($values);
		}

		return $this->create(NULL, TRUE);
	}

} // End Auth User Token Model