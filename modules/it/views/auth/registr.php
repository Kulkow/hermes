<form action="<?php echo URL::site('registr') ?>" method="post" accept-charset="utf-8" class="wide">
	<h3><?php echo t('auth.registr') ?></h3>
	<?php if (count($errors)) : ?>
		<?php $count = count(Arr::flatten($errors)) ?>
		<div class="it-row it-error">
			<?php echo Text::declension('Обнаружена;Обнаружено', $count) ?>
			<?php echo $count ?>
			<?php echo Text::declension('ошибка;ошибки;ошибок', $count) ?>
		</div>
	<?php endif ?>
	<div class="it-row">
		<label for="login-id"><?php echo t('auth.login') ?><sup>*</sup></label>
		<input type="text" name="login" id="login-id" value="<?php echo HTML::chars(Arr::get($_REQUEST, 'login'))?>" class="it-text" />
		<?php if ($error = Arr::get($errors, 'login')) : ?><div class="it-error"><?php echo $error ?></div><?php endif ?>
        <?php if ($error = Arr::path($errors, '_external.login')) : ?><div class="it-error"><?php echo $error ?></div><?php endif ?>
	</div>
	<div class="it-row">
		<label for="password-id"><?php echo t('auth.password') ?><sup>*</sup></label>
		<input type="password" name="password" id="password-id" value="" class="it-text" />
		<?php if ($error = Arr::path($errors, '_external.password')) : ?><div class="it-error"><?php echo $error ?></div><?php endif ?>
		<!--<label for="password-show-id" class="inline hidden"><input type="checkbox" name="password-show" id="password-show-id"<?php if (Arr::get($_REQUEST, 'password-show')) echo ' checked' ?>  value="1" /><?php echo t('auth.password.hint') ?></label>
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
		<label for="email-id"><?php echo t('auth.email') ?><sup>*</sup></label>
		<input type="text" name="email" id="email-id" value="<?php echo HTML::chars(Arr::get($_REQUEST, 'email'))?>" class="it-text" />
		<?php if ($error = Arr::get($errors, 'email')) : ?><div class="it-error"><?php echo $error ?></div><?php endif ?>
	</div>
	<div class="it-row">
		<label for="name-id"><?php echo t('auth.name') ?><sup>*</sup></label>
		<input type="text" name="name" id="name-id" value="<?php echo HTML::chars(Arr::get($_REQUEST, 'name'))?>" class="it-text" />
		<?php if ($error = Arr::get($errors, 'name')) : ?><div class="it-error"><?php echo $error ?></div><?php endif ?>
	</div>
    <div class="it-row">
		<label for="vk-id"><?php echo t('auth.vk') ?></label>
		<input type="text" name="vk" id="vk-id" value="<?php echo HTML::chars(Arr::get($_REQUEST, 'vk'))?>" class="it-text" />
        <?php if ($error = Arr::get($errors, 'vk')) : ?><div class="it-error"><?php echo $error ?></div><?php endif ?>
	</div>
    <div class="it-row">
		<label for="skype-id"><?php echo t('auth.skype') ?></label>
		<input type="text" name="skype" id="skype-id" value="<?php echo HTML::chars(Arr::get($_REQUEST, 'skype'))?>" class="it-text" />
        <?php if ($error = Arr::get($errors, 'skype')) : ?><div class="it-error"><?php echo $error ?></div><?php endif ?>
	</div>
    <div class="it-row">
		<label for="phone-id"><?php echo t('auth.phone') ?><sup>*</sup></label>
		<input type="text" name="phone" id="phone-id" value="<?php echo HTML::chars(Arr::get($_REQUEST, 'phone'))?>" class="it-text" />
		<div class="it-note"><?php echo t('user.phone.notice') ?></div>
        <?php if ($error = Arr::get($errors, 'phone')) : ?><div class="it-error"><?php echo $error ?></div><?php endif ?>
	</div>
    <div class="it-row">
		<label for="referral-id"><?php echo t('auth.referral') ?><sup>*</sup></label>
		<input type="text" name="referral" id="referral-id" value="<?php echo HTML::chars(Arr::get($_REQUEST, 'referral'))?>" class="it-text" />
		<?php if ($error = Arr::get($errors, 'referral')) : ?><div class="it-error"><?php echo $error ?></div><?php endif ?>
	</div>
	<?php $agreement = ORM::factory('page')->with('content')->where('alias', '=', 'agreement')->find(); if ($agreement->loaded()) : ?>
		<div class="it-row">
			<? if(FALSE): ?>
            <label>Прочтите</label>
			<div class="it-area content"><?php echo $agreement->content->content ?></div>
            <? endif ?>
			<label for="agreement" class="inline"><input type="checkbox" id="agreement" name="agreement" value="1" <?php if (array_key_exists('agreement', $_REQUEST)) echo ' checked' ?> />Я согласен с условиями 	<a href="<?php echo $agreement->url() ?>" title="Почитать"> пользовательского соглашения</a></label>
			<?php if ($error = Arr::path($errors, '_external.agreement')) : ?><div class="it-error"><?php echo $error ?></div><?php endif ?>
		</div>
    <?php endif ?>    
	<div class="it-row" id="captcha">
		<label for="captcha-id"><?php echo t('captcha.security') ?></label>
		<div class="security">
			<img src="<?php echo Site::url('captcha') ?>" alt="" /><a href="javascript:;" title="<?php echo t('captcha.update') ?>"></a>
			<input type="text" name="captcha" id="captcha-id" value="" class="it-text" />
		</div>
		<div class="it-note"><?php echo t('captcha.notice') ?></div>
		<?php if ($error = Arr::path($errors, '_external.captcha')) : ?><div class="it-error"><?php echo $error ?></div><?php endif ?>
	</div>
	<div class="it-row last">
		<input type="hidden" name="token" value="<?php echo Security::token() ?>" />
		<button type="submit" name="submit" value="1" class="it-button"><?php echo t('auth.signup') ?></button>
	</div>
</form>
<script>
$(function() {
    
    $('#captcha a').click(function() {
		$('#captcha img').attr('src', '/captcha?r=' + Math.random());
	});
    
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