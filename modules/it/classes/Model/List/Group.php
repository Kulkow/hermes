<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_List_Group extends Model_List
{
	public function values(array $values, array $expected = NULL)
	{
		if (empty($values['group']))
		{
			$values['group'] = $values['group-new'];
		}
		return parent::values($values, $expected);
	}

	public function update(Validation $validation = NULL)
	{
		if ($this->group != $this->_original_values['group'])
		{
			$this->_order_set();
		}
		return parent::update($validation);
	}

	protected function _order_set()
	{
		$sql = "SELECT MAX(`order`) as last FROM ".$this->_table_name." WHERE `group` = :group";
		$last = DB::query(Database::SELECT, $sql)->param(':group', $this->group)->execute()->as_array(NULL, 'last');
		$this->order = (int)array_pop($last) + 1;
	}

	public function groups()
	{
		$sql = "SELECT DISTINCT `group` FROM ".$this->_table_name." ORDER BY `group`";
		return DB::query(Database::SELECT, $sql)->execute($this->_db)->as_array(NULL, 'group');
	}

	public function order_update($data)
	{
		$sql = "SELECT `group` FROM ".$this->_table_name." ORDER BY `group` LIMIT 1";
		$query = DB::query(Database::SELECT, $sql)->execute($this->_db)->as_array(NULL, 'group');
		$group = array_pop($query);
		$order = 1;
		$sql = "UPDATE ".$this->_table_name." SET `group` = :group, `order` = :order WHERE id = :id";
		$query = DB::query(Database::UPDATE, $sql)->bind(':group', $group)->bind(':order', $order)->bind(':id', $id);
		foreach ($data as $id)
		{
			if (is_numeric($id))
			{
				$query->execute($this->_db);
				$order ++;
			}
			else
			{
				$group = substr($id, 1);
				$order = 1;
			}
		}
	}
}