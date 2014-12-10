<h1>Настройки</h1>
<?php echo View::factory('user/sidebar')->bind('side_menu',$side_menu) ?>
<?php if(empty($password)) : ?>
<h1>Новый пароль</h1>
<form action="" method="post" accept-charset="utf-8">
	<div class="it-row">
		<label for="oldpassword-id"><?php echo t('auth.oldpassword') ?></label>
		<input type="password"  class="it-text" id="oldpassword-id" name="oldpassword" value="<?php echo Arr::get($_REQUEST, 'oldpassword') ?>" />
		<?php if ($error = Arr::path($errors, '_external.oldpassword')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <div class="it-row">
		<label for="password-id"><?php echo t('auth.newpassword') ?></label>
		<input type="password" name="password" id="password-id" value="" class="it-text" />
		<?php if ($error = Arr::path($errors, '_external.password')) : ?><div class="it-error"><?php echo $error ?></div><?php endif ?>
	<!--	<label for="password-show-id" class="inline hidden"><input type="checkbox" name="password-show" id="password-show-id"<?php if (Arr::get($_REQUEST, 'password-show')) echo ' checked' ?>  value="1" /><?php echo t('auth.password.hint') ?></label>
		<div id="password-show" class="hidden"></div>-->
	</div>
    <div class="it-row">
		<label for="confirmpassword-id"><?php echo t('auth.confirmpassword') ?></label>
		<input type="password"  class="it-text" id="confirmpassword-id" name="confirmpassword" value="<?php echo Arr::get($_REQUEST, 'confirmpassword') ?>" />
		<?php if ($error = Arr::path($errors, 'confirmpassword')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
	<div class="it-row">
        <input type="hidden" name="token" value="<?php echo Security::token() ?>" />
		<button type="submit" name="submit" value="1" class="it-button">Сохранить</button>
	</div>
</form>


<script>
$(function() {
	var input = $('#password-id'), trigger = $('#password-show-id'), div = $('#password-show');
	trigger.click(function(o, nofocus) {
		if (trigger.prop('checked')) {
			div.slideDown(100);
			input.bind('keyup', function() {
				div.text(input.val());
			}).triggerHandler('keyup');
		} else {
			div.slideUp(100);
			input.unbind('keyup');
		}
		if (!nofocus) input.focus();
	}).triggerHandler('click', 1);
	trigger.parent().show();
});
</script>
<?php else : ?>
<h4>Ваш новый пароль : <?php echo $password ?></h4>
<?php endif ?>
