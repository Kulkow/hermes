Здравствуйте, <b><?php echo $user->fullname() ?>!<br/><br />
Регистрация на сайте &laquo;<a href="<?php echo URL::site('', TRUE, FALSE) ?>"><?php echo $site->name ?></a>&raquo; прошла успешно.<br />
Для подтверждения регистрации пройдите по ссылке <a href="<?php echo URL::site('activate/'.$token, TRUE, FALSE) ?>"><?php echo URL::site('activate/'.$token, TRUE, FALSE) ?></a><br /><br />
С уважением, команда проекта &laquo;<a href="<?php echo URL::site('', TRUE, FALSE) ?>"><?php echo $site->name ?></a>&raquo;.