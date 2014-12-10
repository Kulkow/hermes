<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Config extends Controller_Admin_Layout
{
	public function before()
	{
		parent::before();

		$this->template->sidebar = View::factory('admin/config/sidebar')->set('current', $this->request->action());
	}

	public function action_index()
	{
    	$this->template->content = View::factory('admin/config/index');
	}

	public function action_site()
	{
		if (HTTP_Request::POST == $this->request->method())
		{
			try
			{
				$this->site->values($this->request->post())->save();
				//$this->request->redirect('admin/config');
                Controller::redirect('admin/config');
			}
			catch (ORM_Validation_Exception $e)
			{
				$errors = $e->errors('site');
			}
		}
		else
		{
			$_REQUEST = Arr::merge($_REQUEST, $this->site->as_array());
		}
		$this->template->content = View::factory('admin/config/site')->bind('errors', $errors);
	}

	public function action_skin()
	{
        $skins = array();
        foreach (glob(DOCROOT.'media/skins/*/skin.xml') as $skin)
        {
        	$xml = simplexml_load_file($skin);
			$folder = str_replace(DOCROOT.'media/skins/', '', dirname($skin));
			if ($preview = file_exists(DOCROOT.'media/skins/'.$folder.'/skin.jpg'))
			{
				$preview = '/media/skins/'.$folder.'/skin.jpg';
			}
			$skins[] = array(
				'folder'		=> $folder,
				'name'			=> (string)$xml->name,
				'description' 	=> (string)$xml->description,
				'preview'		=> $preview,
			);
        }

		if (HTTP_Request::POST == $this->request->method())
		{
			try
			{
				$this->site->values($this->request->post())->save();
				//$this->request->redirect('admin/config');
                Controller::redirect('admin/config');
			}
			catch (ORM_Validation_Exception $e)
			{
				$errors = $e->errors('skin');
			}
		}
		else
		{
			$_REQUEST['skin'] = $this->site->skin;
		}
		$this->template->content = View::factory('admin/config/skin')->bind('skins', $skins)->bind('errors', $errors);
	}

	public function action_password()
	{
		if (HTTP_Request::POST == $this->request->method())
		{
			try
			{
				$values = $this->request->post();
				$errors = NULL;

				if ( ! Auth::instance()->check_password($values['password-old']))
				{
					$errors['password-old'] = t('user.password.not_corrent');
				}
				if (mb_strlen($values['password-new']) < 6)
				{
					$errors['password-new'] = t('user.password.min_length');
				}
				if ($errors === NULL)
				{
					$admin = Auth::instance()->get_user();
					$admin->password = $values['password-new'];
					$admin->save();

					//$this->request->redirect('admin/config');
                    Controller::redirect('admin/config');
				}
			}
			catch (ORM_Validation_Exception $e)
			{
				$errors = $e->errors('user');
			}
		}
		$this->template->content = View::factory('admin/config/password')->bind('errors', $errors);
	}

} // End Controller Admin Config
