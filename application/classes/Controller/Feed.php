<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Feed extends Controller_Layout
{
	public function action_index()
	{
		$page = ORM::factory('page', array('alias' => 'feedback'));
		$this->site->assign($page->title, $page->content->keywords, $page->content->description);
        $send = FALSE;

		if (HTTP_Request::POST == $this->request->method())
		{
			
             $values = $this->request->post();
             $validation = Validation::factory($values);
                $validation->rule('name', 'not_empty')
                   ->rule('email','not_empty');
             
             if($validation->check()){
                $email = $this->site->admin_email();
                $params = array('post' => $values);
                $s = Site::email($email, 'feed', 'feed', $params);
                $send = 1;
             }else{
                $errors = $validation->errors('feed');
             }      
            
		}
		$this->template->content = View::factory('feedback')->bind('errors', $errors)->bind('page', $page)->bind('send',$send);
	}

} // End Controller_Feedback