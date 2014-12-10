<h1>Сообщение о изменении персональных данных</h1>
<p>Номер вашей карты <?php echo $user->login  ?></p>
<p>Ваши данные </p>
<?php $show = array('login', 'name', 'email', 'phone'); $show = array_flip($show); ?>
<?php $data = $user->as_array(); $data = array_intersect_key($data, $show);  ?>
<?php foreach($data as $field => $value): ?>
<p><b><?php echo t('auth.'.$field) ?></b>: <?php echo $value ?> </p>
<?php endforeach ?>
<?php echo View::factory('subshrieb/achtnung') ?>
