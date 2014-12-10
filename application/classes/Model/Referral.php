<?php defined('SYSPATH') or die('No direct access allowed.');

//class Model_Referal extends Model_Tree
class Model_Referral extends ORM
{
    protected $_table_name = 'referals';
    
    protected $_belongs_to = array(

    		'user'		=> array(
    			'model'		=> 'user',
    		),
    	);
    /*
    public function rules()
	{
		return array(
			'title' => array(
				array('not_empty'),
				array('min_length', array(':value', 2)),
				array('max_length', array(':value', 70)),
				array(array($this, 'unique'), array('title', ':value')),
			),
			'alias' => array(
				array('not_empty'),
				array('min_length', array(':value', 2)),
				array('max_length', array(':value', 100)),
				array(array($this, 'unique'), array('alias', ':value')),
			),
		);
	}
*/
    public function tree($pid = NULL)
	{
	   if($pid){
	       $tree = ORM::factory('referral')->where('path','LIKE','%.'.$pid.'.%')->order_by('path','asc')->find_all();
           return $tree;
	   }else{
	       $tree = ORM::factory('referral')->order_by('path','asc')->find_all();
           return $tree;
	   }
	} 
    
    public function get_pid(){
        if($this->loaded() AND $this->pid){
            $referral = ORM::factory('referral', array('id' => $this->pid));
            if($referral->loaded()){
                return $referral;
            }
        }
        return FALSE;
    }
   
    public function save(Validation $validation = NULL)
	{
	   $path = NULL;
       if($this->pid){
           $_pid = ORM::factory('referral', intval($this->pid));
           if($_pid->loaded()){
              $path .= $_pid->path;
           }
       }
       if($this->loaded()){
	       $path = ($path ? $path : '.').$this->id.'.';
           $trim = trim($path,'.');
           $level = count(explode('.',$trim));
           $this->path = $path;
           $this->level = $level;
           $save = parent::save($validation);
	   }else{
	       $save = parent::save($validation);
           $path = ($path ? $path : '.').$save->id.'.';
           $trim = trim($path,'.');
           $level = count(explode('.',$trim));
           $this->path = $path;
           $this->level = $level;
           $save->update($validation);
	   }
       return $save;
	}

	public function url_admin($action)
	{
		return '/admin/referral/'.$action.'/'.$this->id;
	}

	public function url()
	{
		return '/'.$this->alias.'.html';
	}
}