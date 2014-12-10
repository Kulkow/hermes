<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Default auth user
 */
class Model_Auth_User extends ODM
{
	protected $_id_alias = 'login';

	protected $_fields = array(
		'login',
		'password',
		'email',
		'name',
		'about',
        'gender',
	);

	protected $_defaults = array(
		'rating'	=> 0,
		'online'	=> 0,
	);

	protected $_has_many = array(
		'roles'		=> array(
			'model' 	=> 'role',
		),
	);

	public function filters()
	{
		return array(
			'email' 	=> array(
				array('strtolower'),
			),
		);
	}

	public function rules()
	{
		return array(
			'login' 	=> array(
				array('not_empty'),
				array('alpha_dash'),
				array('min_length', array(':value', 4)),
				array('max_length', array(':value', 50)),
				array(array($this, 'unique'), array('login', ':value')),
			),
			'password' 	=> array(
				array('not_empty'),
			),
			'email'		=> array(
				array('not_empty'),
				array('email'),
				array(array($this, 'unique'), array('email', ':value')),
			),
		);
	}

	public function create(Validation $validation = NULL, $safe = FALSE)
	{
		if (isset($this->_changed['password']))
		{
			$this->_document['password'] = Auth::hash($this->password);
		}

		return parent::create($validation, $safe);
	}

	public function update(Validation $validation = NULL, $safe = FALSE)
	{
		if (isset($this->_changed['password']))
		{
			$this->_document['password'] = Auth::hash($this->password);
		}

		return parent::update($validation, $safe);
	}

} // End Auth User Model