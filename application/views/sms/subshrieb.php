Сообщение о изменении настроек рассылок с сайта <?php echo $site->name ?>. Номер вашей карты <?php echo $user->login  ?>.
<?php $subshrieb = Arr::get($params,'subshrieb', NULL); ?>
<?php if($subshrieb) : ?>
    <?php echo ((! empty($subshrieb->phone)) ? ''. t('subshrieb.phone.check', array('phone' => $user->phone)).'' : ''); ?>.
    <?php echo ((! empty($subshrieb->email)) ? ''.t('subshrieb.email.check', array('email' => $user->email)).'' : ''); ?>. 
<?php else: ?>
  Изменены настройки рассылки уведомлений.
<?php endif ?>