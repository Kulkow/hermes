<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Cards extends Controller_Admin_Layout
{

    public $sort = 'created';
    public $up = 'desc';
    
    public $session = NULL;
    
    public $search = NULL;
    
    public $users = NULL;
    public $cards = NULL;
    
    public function before()
    {
       // ORM::factory('user', array('login' => '2770003000001'))->values(array('password', '111777'))->update();
        parent::before();
        $this->session = Session::instance();
        $this->users = ORM::factory('user');
        
        if (HTTP_Request::POST == $this->request->method())
		{
		  $values = $this->request->post();
          $field = Arr::get($values,'field', NULL);
          $this->session->set('field', $field); 
          
          $search = Arr::get($values,'search', NULL);
          $this->session->set('search', $search);  

		}
        else
        {
            $field = $this->session->get('field', NULL);
            $search = $this->session->get('search', NULL);
            
        }
        
       if($field AND $search)
       {
          $this->search = array('field' => $field, 'value' => $search);
          //$this->users = $this->users->where($field, 'LIKE', $search.'%');
       }
        
        $this->template->bind_global('search_field',$field);
        $this->template->bind_global('search',$search);
        
    }
    
    public function action_index()
	{
            $per_page = 20;
            $page = $this->request->param('page', 1);
			//$paging = Paging::make($total, $page, 1, $per_page, 'admin/users');
            if(! $this->search)
            {
               $user = $this->users->order_by('created', 'desc')
                         ->offset(($page - 1) * $per_page)->limit($per_page)->find_all();
              $total = $this->users->count_all();                                
            }
            else
            {
               $user = $this->users->where(Arr::get($this->search, 'field'), 'LIKE', '%'.Arr::get($this->search, 'value').'%')
                                    ->order_by('created', 'desc')
                                    ->offset(($page - 1) * $per_page)->limit($per_page)->find_all();
               $total = $this->users->where(Arr::get($this->search, 'field'), 'LIKE', '%'.Arr::get($this->search, 'value').'%')->count_all();                     
            }
            
            //$total = $users->count_all();
            $paging = Paging::make($total, $page, $per_page, $per_page, 'admin/users');
                                   
		$this->template->content = View::factory('admin/cards/index')->bind('users', $user)->bind('paging', $paging);
	}
    
    
    public static function sort()
    {
        
    }
    
    
    public static function search()
    {
        if (HTTP_Request::POST == $this->request->method())
		{
		  $values = $this->request->post();
          $field = Arr::get($values,'field', NULL);
          $this->session->set('field', $field); 
          
          $search = Arr::get($values,'search', NULL);
          $this->session->set('search', $search);  
          //$referrer = $this->request->referrer();
		}
    }
    
    protected static function _search($field, $value)
    {
       if($field AND $value)
       {
          return $this->users->where($field, '=', $value);
       }
    }  
 }       