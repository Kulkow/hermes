Здравствуйте, <b><?php echo $user->login ?>!<br/><br />
Для вас создан новый пароль на сайте &laquo;<a href="<?php echo URL::site('', TRUE, FALSE) ?>"><?php echo $site->name ?></a>&raquo;.<br /><br />
Регистрационные данные:<br />
Логин: <b><?php echo $user->login ?></b><br />
Пароль: <b><?php echo $password ?></b><br /><br />
С уважением, команда проекта &laquo;<a href="<?php echo URL::site('', TRUE, FALSE) ?>"><?php echo $site->name ?></a>&raquo;.
