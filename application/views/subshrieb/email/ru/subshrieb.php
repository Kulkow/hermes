<h1>Сообщение о изменении настроек рассылок с сайта</h1>
<p>Номер вашей карты <?php echo $user->login  ?></p>
<?php if(! empty($subshrieb)) : ?>
    <?php echo ((! empty($subshrieb->phone)) ? '<p>'. t('subshrieb.phone.check', array('phone' => $user->phone)).'</p>' : ''); ?>
    <?php echo ((! empty($subshrieb->email)) ? '<p>'.t('subshrieb.email.check', array('email' => $user->email)).'</p>' : ''); ?> 
<?php else: ?>
  <p>Изменены настройки рассылки уведомлений</p>
<?php endif ?>