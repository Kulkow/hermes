<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Logs extends Controller_Admin_Layout
{

    public $sort = 'created';
    public $up = 'desc';
    
    
    public function action_index()
	{
		if ($total = ORM::factory('log')->count_all())
		{
			$per_page = 30;
            $page = $this->request->param('page', 1);
			$paging = Paging::make($total, $page, $per_page, 4, 'admin/logs');
			$logs = ORM::factory('log')->order_by('created', 'desc')
				->offset(($page - 1) * $per_page)->limit($per_page)->find_all();
                
            /*
            $page = str_replace('page','',$this->request->param('urlex', 1));
            $page = $this->request->param('page', 1);
            $this->users = ODM::factory('user')->find_all()->sort($sorty)->skip(($page - 1) * $per_page)->limit((int) $per_page);
            $paging = $per_page ? Paging::make($this->users->count(), $page, $per_page, 4, 'users/'.($this->sort ? $this->sort : '')) : NULL;
            */    
    	}
        
        $filters = Model_Filter::instance('user', array('filters' => array('login', 'phone', 'email'),
                                          'orders' => array('login', 'phone', 'email'))
                                          );
                                 
		$this->template->content = View::factory('admin/logs/index')->bind('logs', $logs)->bind('paging', $paging);
	}
    
    
    public static function sort()
    {
        
    }
    
    
    public static function search()
    {
        
    }  
 }   