<?php defined('SYSPATH') or die('No direct script access.');
 
/**
 * Its a test task class
 *
 * @author biakaveron
 */
class Task_Welcome extends Minion_Task {
 
	protected $_options = array(
		// param name => default value
		'foo'   => 'beautiful',
	);
 
	/**
	 * Test action
	 *
	 * @param array $params
	 * @return void
	 */
	protected function _execute(array $params)
	{
		Minion_CLI::write('hello '.$params['foo'].' world!');
	}
 
}