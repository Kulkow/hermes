<?php defined('SYSPATH') or die('No direct access allowed.');

return array(
	'registr'						=> 'Регистрация',
    'fio'				     		=> 'Ф.И.О.',
    'vk'				     		=> 'Страница в соц.сети',
    'skype'				     		=> 'SKYPE',
	//'login'							=> 'Логин',
    'login'							=> 'Логин',
	'login.notice'					=> 'Логин',
	'login.not_empty'				=> 'Не введен Логин',
    'login.min_length'				=> 'Длина логина должна быть от :param2 символов',
	//'login.max_length'				=> 'Длина логина должна быть не более :param2 символов',
    'login.alpha_dash'				=> 'Логин должен состоять только из латинских букв, цифр и знака подчеркивания',
    'login.unique'					=> 'Логин уже занят',
	'password'						=> 'Пароль',
    'newpassword'                   => 'Новый пароль',
	'password.not_empty'			=> 'Не введен пароль',
    'password.min_length'   		=> 'Длина пароля должна быть от :param2 символов',
    'new_password.not_empty'		=> 'Не введен пароль',
    'new_password.min_length'   	=> 'Длина пароля должна быть от :param2 символов',
    'oldpassword.not_empty'         => 'Введите старый пароль',
    'oldpassword.check_password'    => 'неправильно указан старый пароль',
	'password.hint'					=> 'Показать пароль',
    'password.equals'               => 'Пароли не совпадают',
	'email'							=> 'Email',
	'email.not_empty'				=> 'Не введен email',
    'email.email'					=> 'Email должен быть действительным email адресом',
    'email.unique'					=> 'Email занят',
	'name'							=> 'ФИО',
	'name.not_empty'				=> 'Введите Ваше ФИО',
    
    'address'                       => 'Адрес',
    'phone'                         => 'Телефон',
    'phone.not_empty'				=> 'введите ваш номер телефона',
    'phone.notice'					=> 'номер телефона вводить в формате +79271234567',
    
    'token'                         => 'Код с чека',
    'token.not_empty'               => 'Укажите код с чека',
    'token.notice'                  => 'необходимо указать код из любого чека, выданного присовершении покупки',

	'agreement.not_empty'			=> 'Для пользования сайтом необходимо согласиться с правилами',

	'password.new'                  => 'Пароль успешно изменён',
    'registr.success'				=> 'Регистрация прошла успешно',
	'registr.success.message' 		=> 'Для подтверждения регистрации пройдите по ссылке высланной в письме на Ваш электронный адрес.',

	'activate'						=> 'Активация аккаунта',
	'activate.message'				=> 'Здраствуйте, :login. Ваш аккаунт активирован.',
	'activate.error'				=> 'Ошибка активации',
	'activate.error.message'		=> 'Пользователь не найден, вероятно не верно передан код активации.',

	'auth'							=> 'Авторизация',
	//'login.email'					=> 'Номер бонусной карты или email',
    'login.email'					=> 'Email или логин',
	'remember'						=> 'Запомнить меня',
	'auth.error'					=> 'Не верное имя пользователя или пароль',

	'forgot'						=> 'Восстановление пароля',
	'forgot.send'					=> 'Отправить',
	'forgot.error'					=> 'Пользователь не найден',
	'forgot.sended'					=> 'Напоминание пароля',
	'forgot.sended.message'			=> 'На Ваш электронный адрес :email выслано письмо (:phone), пройдите по ссылке в нем для получения нового пароля.',
	'confirm'						=> 'Подтверждение напоминания пароля',
    'confirm.message'				=> 'Вы воспользовались системой восстановления доступа для пользователя :login. Новый пароль для входа на сайт выслан Вам на электронную почту.',
    'confirm.error'					=> 'Ошибка подтверждения напоминания пароля',
    'confirm.error.message'			=> 'Передан не верный код подтверждения.',

	'signin'						=> 'Войти',
	'signup'						=> 'Зарегистрироваться',

	'captcha.not_empty'				=> 'Не введены символы с картинки',
	'captcha.Captcha::valid'		=> 'Не верно введены символы с картинки',
    'password.Controller_User::check_password' => 'Не верно введен старый пароль',

);
