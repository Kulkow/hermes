<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Cache extends ODM
{
	protected $_collection = 'cache';

	public function get($key, $fields = NULL)
	{		return $this->find(array('_id' => $key), $fields ? $fields + array('_id' => 1, 'expires' => 1) : array());
	}

	public function set($key, array $data, $lifetime = 0)
	{		if ($lifetime > 0)
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
	{		if ($this->_loaded)
		{			if ($this->expires < time())
			{				$this->delete();
				return TRUE;			}
			return FALSE;
		}
		return TRUE;
	}

	public function update(Validation $validation = NULL, $safe = FALSE)
	{		$this->expires = time() + $this->lifetime;
		return parent::update($validation, $safe);	}

	public function remove($criteria, array $options = array())
	{		if ($criteria instanceof ODM)
		{			if ($criteria->loaded())
			{				$criteria = array('$or' => array(
					array('data.model' => $criteria->model(), 'data.array' => $criteria->_id),
					array($criteria->model() => $criteria->_id),
				));
			}
			else
			{				$criteria = array('$or' => $this->_build($criteria));
			}		}
		return parent::remove($criteria, $options);	}

	protected function _build(ODM $model, $criteria = array())
	{		foreach ($model->belongs_to() + $model->has_one() as $alias => $details)
		{			$parent = $model->$alias;
			if ($parent->loaded())
			{				$or = array($alias => $parent->_id);
				if ( ! in_array($or, $criteria))
				{					$criteria[] = $or;
					$criteria += $this->_build($parent, $criteria);
				}
			}
		}
		return $criteria;	}

} // End Model Cache
