<h1>Настройки</h1>
<?php echo View::factory('user/sidebar')->bind('side_menu',$side_menu) ?>
<h2>Настройка уведомлений</h2>
    <div class="message">
     <p>На сайте работает система уведомлений:</p>
     <ol>
        <!--<li>сообщение о входе на сайт (на случай взлома если кто-то другой зашел под вашим аккаунтом).</li>-->
        <li>сообщение о изменении имени, телефона,  email, адреса (при смене телефона или email - отправляются и по старым данным)</li>
        <li>сообщение о изменении пароля.</li>
        <li>сообщение о операциях с бонусной картой (налисление, списание бонусных баллов, и др. операции):</li>
     </ol>
     </div>
<?php if(empty($subshrieb_set)) : ?>
<form action="" method="post" accept-charset="utf-8">
	<?php if($user->email) : ?>
    <div class="it-row">
		<div class="it-check">
          <label for="email-id"><?php echo t('subshrieb.email', array('email' => $user->email)) ?></label>
		   <input type="checkbox" id="email-id" name="email" <?php echo (Arr::get($_REQUEST, 'email') ? 'checked="checked"' : '') ?> value="1" />
        </div>
	</div>
    <?php else: ?>
    <div class="it-row"><a href="" title="Редактировать профиль"><?php echo t('subshrieb.email.none') ?></a></div>
    <?php endif ?>
    <?php if($user->phone) : ?>
    <div class="it-row">
		<div class="it-check">
            <label for="phone-id"><?php echo t('subshrieb.phone', array('phone' => $user->phone)) ?></label>
		    <input type="checkbox" id="phone-id" name="phone" <?php echo (Arr::get($_REQUEST, 'phone') ? 'checked="checked"' : '') ?> value="1" />
        </div>
	</div>
    <?php else: ?>
     <div class="it-row"><a href="" title="Редактировать профиль"><?php echo t('subshrieb.phone.none') ?></a></div>
    <?php endif ?>
	<div class="it-row">
        <input type="hidden" name="token" value="<?php echo Security::token() ?>" />
		<button type="submit" name="submit" value="1" class="it-button">Сохранить</button>
	</div>
</form>
<?php else : ?>
   <div class="message it-assess">
        <h2>Сохранено</h2>
        <p><?php echo ($subshrieb_set->phone ? t('subshrieb.phone.check', array('phone' => $user->phone)) : ''); ?></p>
        <p><?php echo ($subshrieb_set->email ? t('subshrieb.email.check', array('email' => $user->email)) : ''); ?></p>
   </div>  
    <p><a href="<?php echo $user->url('subscription') ?>" title="Назад к настройке уведомлений" class="right">Назад к настройке уведомлений</a></p>
    
<?php endif ?>