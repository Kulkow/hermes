<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Default auth role
 */
class Model_Auth_Role extends ODM
{
	protected $_id_alias = 'name';

	protected $_has_many = array(
		'users'		=> array(
			'model' 	=> 'user',
		),
	);

	public function filters()
	{
		return array(
			TRUE	=> array(
				array('trim'),
			),
//			'name'	=> array(
//				array('Javix::parse', array(':value', 'striptags')),
//			),
//			'desc'	=> array(
//				array('Javix::parse'),
//			),
		);
	}

	public function rules()
	{
		return array(
			'name' 			=> array(
				array('not_empty'),
				//array('alpha_dash'),
			),
		);
	}

} // End Auth Role Model