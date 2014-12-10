<form action="<?php echo URL::site('forgot') ?>" method="post" accept-charset="utf-8">
	<h3><?php echo t('auth.forgot') ?></h3>
	<div class="it-row">
		<label for="login-id"><?php echo t('auth.login') ?></label>
		<input type="text" name="login" id="login-id" value="<?php echo HTML::chars(Arr::get($_REQUEST, 'login'))?>" class="it-text" />
		<?php if ($error = Arr::get($errors, 'login')) : ?><div class="it-error"><?php echo $error ?></div><?php endif ?>
	</div>
	<?php if ($captcha) : ?>
		<div class="it-row" id="captcha">
			<label for="captcha-id"><?php echo t('captcha.security') ?></label>
			<div class="security">
				<img src="<?php echo Site::url('captcha') ?>" alt="" /><a href="javascript:;" title="<?php echo t('captcha.update') ?>"></a>
				<input type="text" name="captcha" id="captcha-id" value="" class="it-text" />
			</div>
			<div class="it-note"><?php echo t('captcha.notice') ?></div>
			<?php if ($error = Arr::path($errors, '_external.captcha')) : ?><div class="it-error"><?php echo $error ?></div><?php endif ?>
		</div>
	<?php endif ?>
	<div class="it-row last">
		<input type="hidden" name="token" value="<?php echo Security::token() ?>" />
		<button type="submit" name="submit" value="1" class="it-button"><?php echo t('auth.forgot.send') ?></button>
	</div>
</form>