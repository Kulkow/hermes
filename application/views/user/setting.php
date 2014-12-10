<h1>Настройки</h1>
<?php echo View::factory('user/sidebar')->bind('side_menu',$side_menu) ?>
<?php if(! empty($save)) : ?>
<?php Message::notice('Данные сохранены');?>
<?php endif ?>
<form action="" method="post" accept-charset="utf-8">
     <?php if(count($errors) > 0) : ?>
            <?php echo implode(',',$errors); ?>
     <?php endif ?>
    <div class="it-row">
		<label for="name-id"><?php echo t('auth.name') ?></label>
		<input type="text"  class="it-text" id="name-id" name="name" value="<?php echo Arr::get($_REQUEST, 'name') ?>" />
		<?php if ($error = Arr::get($errors, 'name')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
	<div class="it-row">
		<label for="email-id"><?php echo t('auth.email') ?></label>
		<input type="text" class="it-text" id="email-id" name="email" value="<?php echo Arr::get($_REQUEST, 'email') ?>" />
		<?php if ($error = Arr::get($errors, 'email')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <div class="it-row">
		<label for="phone-id"><?php echo t('auth.phone') ?></label>
		<input type="text" class="it-text" id="phone-id" name="phone" value="<?php echo Arr::get($_REQUEST, 'phone') ?>" />
		<?php if ($error = Arr::get($errors, 'phone')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <div class="it-row">
		<label for="skype-id"><?php echo t('auth.skype') ?></label>
		<input type="text" class="it-text" id="skype-id" name="skype" value="<?php echo Arr::get($_REQUEST, 'skype') ?>" />
		<?php if ($error = Arr::get($errors, 'skype')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <div class="it-row">
		<label for="vk-id"><?php echo t('auth.vk') ?></label>
		<input type="text" class="it-text" id="vk-id" name="vk" value="<?php echo Arr::get($_REQUEST, 'vk') ?>" />
		<?php if ($error = Arr::get($errors, 'vk')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
	<div class="it-row">
        <input type="hidden" name="token" value="<?php echo Security::token() ?>" />
		<button type="submit" name="submit" value="1" class="it-button">Сохранить</button>
	</div>
</form>



