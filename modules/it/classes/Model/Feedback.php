<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Feedback extends ORM
{
	/*
    protected $_fields = array(
		'theme',
		'message',
	);

	protected $_belongs_to = array(
		'user'		=> array(
			'model'		=> 'user',
		),
	);
    */

	public function filters()
	{
		return array(
			'theme' 	=> array(
				array('HTML::strip_tags'),
			),
			/*'message' 	=> array(
				array('SEO::parse'),
			),*/
		);
	}

	public function rules()
	{
		return array(
			'theme'		=> array(
				array('not_empty'),
				array('min_length', array(':value', 2)),
			),
			'message'	=> array(
				array('not_empty'),
			),
		);
	}

	public function send()
	{
		$body  = t('feedback.user').': <a href="'.$this->user->url().'">'.$this->user->login.'</a><br>';
		$body .= 'email: '.$this->user->email.'<br><br>';
		$body .= t('feedback.theme').': '.$this->theme.'<br>';
		$body .= t('feedback.message').':<br>'.$this->message;
		$options = t('feedback.'.$this->type);
		foreach (explode(';', $options['email']) as $email)
		{
	    	Email::send($email, 'no-reply@teenterra.ru', $options['subject'], $body, TRUE);
	    }
    	return $this;
	}

} // End Model_Feedback
