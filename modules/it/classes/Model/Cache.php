<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Cache extends ODM
{
	protected $_collection = 'cache';

	public function get($key, $fields = NULL)
	{
	}

	public function set($key, array $data, $lifetime = 0)
	{
		{
			$delta = round($lifetime/10);
			$lifetime = $lifetime + mt_rand(-$delta, $delta);
		}
		else
		{
			$lifetime = Date::YEAR;
		}

		$this->values($data);
		$this->_id = $key;
		$this->expires = time() + $lifetime;
		$this->lifetime = $lifetime;

		return $this->create();
	}

	public function expired()
	{
		{
			{
				return TRUE;
			return FALSE;
		}
		return TRUE;
	}

	public function update(Validation $validation = NULL, $safe = FALSE)
	{
		return parent::update($validation, $safe);

	public function remove($criteria, array $options = array())
	{
		{
			{
					array('data.model' => $criteria->model(), 'data.array' => $criteria->_id),
					array($criteria->model() => $criteria->_id),
				));
			}
			else
			{
			}
		return parent::remove($criteria, $options);

	protected function _build(ODM $model, $criteria = array())
	{
		{
			if ($parent->loaded())
			{
				if ( ! in_array($or, $criteria))
				{
					$criteria += $this->_build($parent, $criteria);
				}
			}
		}
		return $criteria;

} // End Model Cache