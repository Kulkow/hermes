<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_List extends ORM
{
	public function values(array $values, array $expected = NULL)
	{
		$values['hide'] = array_key_exists('hide', $values) ? 0 : 1;
		return parent::values($values, $expected);
	}

	public function create(Validation $validation = NULL)
	{
        $this->_order_set();
		return parent::create($validation);
	}

	protected function _order_set()
	{
		$sql = "SELECT MAX(`order`) as last FROM ".$this->_table_name;
		$last = DB::query(Database::SELECT, $sql)->execute()->as_array(NULL, 'last');
		$this->order = (int)array_pop($last) + 1;
	}

	public function order_update($data)
	{
		$sql = "SELECT id, `order` FROM ".$this->_table_name." ORDER BY `order`";
		$items = DB::query(Database::SELECT, $sql)->execute($this->_db)->as_array('id');

		$order = 1;
		$sql = "UPDATE ".$this->_table_name." SET `order` = :order WHERE id = :id";
		$query = DB::query(Database::UPDATE, $sql)->bind(':order', $order)->bind(':id', $id);
		foreach ($data as $id)
		{
			if ($items[$id]['order'] != $order)
			{
				$query->execute($this->_db);
			}
			$order ++;
		}
	}

	public function url_admin($action)
	{
		return '/admin/'.$this->_object_name.'/'.$action.'/'.$this->id.URL::query();
	}
}