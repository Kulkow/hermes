<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Tree extends ORM
{
	public function tree($parent = TRUE)
	{
		$tree = ORM::factory($this->_object_name)->order_by('l_key');
		if ($this->loaded())
		{
			if ($parent)
			{
				$tree->where('l_key', '>=', $this->l_key)->and_where('r_key', '<=', $this->r_key);
			}
			else
			{
				$tree->where('l_key', '>', $this->l_key)->and_where('r_key', '<', $this->r_key);
			}
		}
		return $tree->find_all();
	}

	protected $_parent = NULL;

	public function parent()
	{
		if ( ! $this->_loaded)
			throw new Kohana_Exception('Cannot get parent :model model because it is not loaded.', array(':model' => $this->_object_name));

		if ($this->_parent === NULL AND $this->pid)
		{
			$this->_parent = ORM::factory($this->_object_name, $this->pid);
			if ( ! $this->_parent->loaded())
			{
				$this->_parent = FALSE;
			}
		}
		return $this->_parent;
	}

	protected $_children = NULL;

	public function children($only_pk = FALSE)
	{
		if ( ! $this->_loaded)
			throw new Kohana_Exception('Cannot get children :model model because it is not loaded.', array(':model' => $this->_object_name));

		if ( ! $children = Arr::get($this->_children, $only_pk))
		{
			$children = ORM::factory($this->_object_name)
				->where('l_key', '>=', $this->l_key)
				->and_where('r_key', '<=', $this->r_key)
				->order_by('l_key');

			if ($only_pk)
			{
				$children->select($this->_primary_key);
			}

			$children = $children->find_all();

			if ($only_pk)
			{
				$children = $children->as_array(NULL, 'id');
			}

			$this->_children[$only_pk] = $children;
		}
		return $children;
	}

	public function values(array $values, array $expected = NULL)
	{
		if ($pid = Arr::get($values, 'pid'))
		{
			$this->_parent = ORM::factory($this->_object_name, $pid);
			if ( ! $this->_parent->loaded())
				throw new Kohana_Exception('Cannot find parent in :model model.', array(':model' => $this->_object_name));
		}
		return parent::values($values, $expected);
	}

	public function create(Validation $validation = NULL)
	{
		if ($this->_loaded)
			throw new Kohana_Exception('Cannot create :model model because it is already loaded.', array(':model' => $this->_object_name));

		if ( ! $this->_valid)
		{
			$this->check($validation);
		}

		$this->_db->begin();

		try
		{
			if ($this->_parent)
			{
				$this->l_key = $this->_parent->r_key;
				$this->r_key = $this->_parent->r_key + 1;
				$this->level = $this->_parent->level + 1;

				$sql = "
					UPDATE ".$this->_table_name."
					SET
					l_key = CASE
								WHEN l_key > ".$this->l_key."
									THEN l_key + 2
								ELSE l_key
							END,
					r_key = r_key + 2
					WHERE
						r_key >= ".$this->l_key."
				";
				DB::query(Database::UPDATE, $sql)->execute($this->_db);
			}
			else
			{
				$key = $this->_max_key();
				$this->l_key = $key + 1;
				$this->r_key = $key + 2;
				$this->level = 1;
			}

			parent::create($validation);

			$this->_db->commit();
		}
		catch (Kohana_Exception $e)
		{
			$this->_db->rollback();

			throw $e;
		}
		return $this;
	}

	public function update(Validation $validation = NULL)
	{
		$moved = $this->pid != $this->_original_values['pid'];

		$this->_db->begin();

		try
		{
			parent::update($validation);

			if ($moved)
			{
				if ($this->_parent)
				{
					$p_l_key = $this->_parent->l_key;
					$p_r_key = $this->_parent->r_key;
					$p_level = $this->_parent->level;

					if ($p_l_key < $this->l_key AND $p_r_key > $this->r_key AND $p_level < $this->level - 1)
					{
		                /**
    		             * перемещение внутри ветки
        		         */
						$key = (($p_r_key - $this->r_key - $this->level + $p_level) / 2) * 2 + $this->level - $p_level - 1;
						$sql = "
							UPDATE ".$this->_table_name."
							SET
							level = CASE
										WHEN l_key BETWEEN ".$this->l_key." AND ".$this->r_key."
											THEN level ".sprintf('%+d', $p_level - $this->level + 1)."
										ELSE level
									END,
							r_key = CASE
										WHEN r_key BETWEEN ".($this->r_key + 1)." AND ".($p_r_key - 1)."
											THEN r_key - ".($this->r_key - $this->l_key + 1)."
										WHEN l_key BETWEEN ".$this->l_key." AND ".$this->r_key."
											THEN r_key + ".$key."
										ELSE r_key
									END,
							l_key = CASE
										WHEN l_key BETWEEN ".($this->r_key + 1)." AND ".($p_r_key - 1)."
											THEN l_key - ".($this->r_key - $this->l_key + 1)."
										WHEN l_key BETWEEN ".$this->l_key." AND ".$this->r_key."
											THEN l_key + ".$key."
										ELSE l_key
									END
							WHERE
								l_key BETWEEN ".($p_l_key + 1)." AND ".($p_r_key - 1)."
						";
					}
					elseif ($p_l_key < $this->l_key)
					{
						/**
						 * перемещение вверх
						 */
						$sql = "
							UPDATE ".$this->_table_name."
							SET
							level = CASE
										WHEN l_key BETWEEN ".$this->l_key." AND ".$this->r_key."
											THEN level ".sprintf('%+d', $p_level - $this->level + 1)."
										ELSE level
									END,
							l_key = CASE
										WHEN l_key BETWEEN ".$p_r_key." AND ".($this->l_key - 1)."
											THEN l_key + ".($this->r_key - $this->l_key + 1)."
										WHEN l_key BETWEEN ".$this->l_key." AND ".$this->r_key."
											THEN l_key - ".($this->l_key - $p_r_key)."
										ELSE l_key
									END,
							r_key = CASE
										WHEN r_key BETWEEN ".$p_r_key." AND ".$this->l_key."
											THEN r_key + ".($this->r_key - $this->l_key + 1)."
										WHEN r_key BETWEEN ".$this->l_key." AND ".$this->r_key."
											THEN r_key - ".($this->l_key - $p_r_key)."
										ELSE r_key
									END
							WHERE
								l_key BETWEEN ".$p_l_key." AND ".$this->r_key."
							OR
								r_key BETWEEN ".$p_l_key." AND ".$this->r_key."
						";
	            	}
    	        	else
        	    	{
						/**
						 * перемещение вниз
						 */
						$sql = "
							UPDATE ".$this->_table_name."
							SET
							level = CASE
										WHEN l_key BETWEEN ".$this->l_key." AND ".$this->r_key."
											THEN level ".sprintf('%+d', $p_level - $this->level + 1)."
										ELSE level
									END,
							l_key = CASE
										WHEN l_key BETWEEN ".$this->r_key." AND ".$p_r_key."
											THEN l_key - ".($this->r_key - $this->l_key + 1)."
										WHEN l_key BETWEEN ".$this->l_key." AND ".$this->r_key."
											THEN l_key + ".($p_r_key - $this->r_key - 1)."
										ELSE l_key
									END,
							r_key = CASE
										WHEN r_key BETWEEN ".($this->r_key + 1)." AND ".($p_r_key - 1)."
											THEN r_key - ".($this->r_key - $this->l_key + 1)."
										WHEN r_key BETWEEN ".$this->l_key." AND ".$this->r_key."
											THEN r_key + ".($p_r_key - $this->r_key - 1)."
										ELSE r_key
									END
							WHERE
								l_key BETWEEN ".$this->l_key." AND ".$p_r_key."
							OR
								r_key BETWEEN ".$this->l_key." AND ".$p_r_key."
						";
	            	}
				}
				else
				{
					/**
					 * перемещение в корень
					 */
					$key = $this->_max_key();
					$offset = $this->r_key - $this->l_key;
					$sql = "
						UPDATE ".$this->_table_name."
						SET
							level = CASE
										WHEN l_key BETWEEN ".$this->l_key." AND ".$this->r_key."
											THEN level - ".($this->level - 1)."
										ELSE level
									END,
							l_key =	CASE
										WHEN l_key BETWEEN ".$this->l_key." AND ".$this->r_key."
											THEN l_key + ".($key - $this->r_key)."
										WHEN l_key > ".$this->r_key."
											THEN l_key - ".($this->r_key - $this->l_key + 1)."
										ELSE l_key
									END,
							r_key = CASE
										WHEN r_key BETWEEN ".$this->l_key." AND ".$this->r_key."
											THEN r_key + ".($key - $this->r_key)."
										WHEN r_key > ".$this->r_key."
											THEN r_key - ".($this->r_key - $this->l_key + 1)."
										ELSE r_key
									END
						WHERE
							l_key >= ".$this->l_key."
						OR
							r_key >= ".$this->r_key."
					";
				}

				DB::query(Database::UPDATE, $sql)->execute($this->_db);
            }

           	$this->_db->commit();
		}
		catch (Kohana_Exception $e)
		{
			$this->_db->rollback();

			throw $e;
		}
    	return $this;
	}

	public function delete()
	{
		if ( ! $this->_loaded)
			throw new Kohana_Exception('Cannot delete :model model because it is not loaded.', array(':model' => $this->_object_name));

		$this->_db->begin();

		try
		{
			$sql = "DELETE FROM ".$this->_table_name." WHERE l_key >= ".$this->l_key." AND r_key <= ".$this->r_key;
			DB::query(Database::DELETE, $sql)->execute($this->_db);

			$offset = $this->r_key - $this->l_key + 1;
			$sql = "
				UPDATE ".$this->_table_name."
				SET
				l_key = CASE
							WHEN l_key > ".$this->l_key."
								THEN l_key - ".$offset."
							ELSE l_key
						END,
				r_key = r_key - ".$offset."
				WHERE r_key > ".$this->r_key."
			";
			DB::query(Database::UPDATE, $sql)->execute($this->_db);

			$this->_db->commit();
		}
		catch (Kohana_Exception $e)
		{
			$this->_db->rollback();

			throw $e;
		}

		return $this->clear();
	}

	protected function _max_key()
	{
		$sql = "SELECT MAX(r_key) AS `key` FROM ".$this->_table_name;
		$result = DB::query(Database::SELECT, $sql)->execute($this->_db);
		if ( ! $key = $result[0]['key'])
		{
			$key = 0;
		}
		return $key;
	}

	/*
	 * обновляет вложенные множества в соответствие со списками смежности
	 */
	public function repair($pid = 0, $l_key = 1, $level = 1)
	{
		if( ! is_numeric($k_key) OR ! is_numeric($pid))
		{
			return FALSE;
		}

		foreach (ORM::factory($this->_object_name)->where('pid', '=', $pid)->find_all() as $node)
		{
			$node->l_key = $l_key;
			$node->r_key = $this->_repair_node($node->id, $l_key + 1, $level + 1);
			$node->level = $level;
			$node->update();
			$l_key = $node->r_key + 1;
		}
		return $l_key;
	}
}