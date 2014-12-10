<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Filter extends Model {
    
    public $session = NULL;
    
    public $model;
    protected $self;
    public $fields = array();
    
    public $filters = array();
    public $orders = array();
    
    public $filter = NULL;
    public $order = NULL;
    
    static public function instance($model, $config = array())
    {
        
        if($model instanceof ORM)
        {
           $model = $model->model();
        }
        $new = new Model_Filter();
        $new->model = $model;
        $new->session = Session::instance();
         
        if($filters = Arr::get($config, 'filters', FALSE))
        {
            $new->filters = $filters;
        }
        if($orders = Arr::get($config, 'orders', FALSE))
        {
            $new->orders = $orders;
        }
        return $new;
    }
    
    public function labels()
    {
       return array(); 
    }
    
    public function order()
    {
        //$this->filter = array();
        if($order = $this->session->get('order', FALSE))
        {
           $field = Arr::get($order, 'field', NULL);
           $by = Arr::get($order, 'by', 'desc');
           if(! $field) return FALSE;
           return $order = array('field' => $field, 'by' => $by);
             
        }
        return FALSE;
    }
    
    public function order_set($field = NULL, $by = 'desc')
    {
        if($field)
        {
           $order = array('field' => $field, 'by' => $by);
           $this->session->set('order', $order);
           return $this->order = $order; 
        }
        return FALSE;
    }
    
    public function filter_set($field = NULL, $value = NULL)
    {
        if(is_array($value) AND $field)
        {
           $value = Arr::get($value,$field, NULL); 
        }
        
        if($field AND $value)
        {
           $filter = array('field' => $field, 'value' => $value);
           $this->session->set('filter', $filter);
           return $this->filter = $filter; 
        }
        return FALSE;
    }
    
    public function filter($request = array())
    {
        //$this->filter = array();
        if($order = $this->session->get('filter', FALSE))
        {
           $field = Arr::get($order, 'field', NULL);
           $by = Arr::get($order, 'by', 'desc');
        }
    }
    
    public function url($order = NULL)
    {
        return Site::url('admin/'.$this->model.'/'.$action);
    }
    
}