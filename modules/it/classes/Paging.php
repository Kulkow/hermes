<?php defined('SYSPATH') or die('No direct script access.');

class Paging
{	public $current = NULL;
	public $count = NULL;

	public $left = array();
	public $right = array();

	public $next = NULL;
	public $prev = NULL;

	public $first = NULL;
	public $last = NULL;

	public $url = NULL;
	public $urlex = NULL;

	public static function make($total, $current, $per_page, $lines, $url, $urlex = '')
	{		return new self($total, $current, $per_page, $lines, $url, $urlex);
	}

	protected function __construct($total, $current, $per_page, $lines, $url, $urlex)
	{
		if ($total > 1)
		{
			$this->current = $current;

			for ($index = max(1, $current - $lines); $index < $current; $index++)
			{
				$this->left[] = $index;
			}
			$this->count = ceil($total/$per_page);
			for ($index = $current + 1; $index <= $current + $lines AND $index <= $this->count; $index++)
			{
				$this->right[] = $index;
			}

			$this->next = $current < $this->count ? $current + 1 : NULL;
			$this->prev = $current > 1 ? $current - 1 : NULL;

			if (reset($this->left) > 1)
			{
				$this->first = 1;
			}
			if (end($this->right) < $this->count AND $current < $this->count)
			{
				$this->last = $this->count;
			}

			$this->url = URL::site($url);
			$this->urlex = $urlex;
        }
		return $this;
	}

	public function render($view = NULL)
	{
		if ($this->current AND $this->count > 1)
		{			if ($view === NULL)
			{
				$view = 'paging';
			}

			if ( ! $view instanceof View)
			{
				$view = View::factory($view);
			}
			$view->bind('paging', $this);
			return $view->render();
		}
		return '';
	}

	public function __toString()
	{		return $this->render();	}

	public function url($page)
	{		return $this->url.($page > 1 ? ($this->urlex ? '/'.$this->urlex : '').'/page'.$page : '');	}
}