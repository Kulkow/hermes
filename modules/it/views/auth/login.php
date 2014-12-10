<form action="<?php echo URL::site('login') ?>" method="post" accept-charset="utf-8">
	<h3><?php echo t('auth.auth') ?></h3>
    <?php if ($error = Arr::path($errors, 'firefall')) : ?>
		<div class="it-row"><div class="it-error"><?php echo $error ?></div></div>
	<?php else: ?>
	<?php if ($error = Arr::get($errors, 'login')) : ?>
		<div class="it-row"><div class="it-error"><?php echo $error ?></div></div>
	<?php endif ?>
	<div class="it-row">
		<label for="login-id"><?php echo t('auth.login.email') ?></label>
		<input type="text" name="login" id="login-id" value="<?php echo HTML::chars(Arr::get($_REQUEST, 'login'))?>" class="it-text" />
	</div>
	<div class="it-row">
		<label for="password-id"><?php echo t('auth.password') ?></label>
		<input type="password" name="password" id="password-id" value=""  class="it-text"/>
	</div>
	<div class="it-row">
		<label for="remember-id" class="inline"><input type="checkbox" name="remember" id="remember-id"<?php if (Arr::get($_REQUEST, 'remember')) echo ' checked' ?> value="1" /><?php echo t('auth.remember') ?></label>
	</div>
	<?php if ($captcha) : ?>
		<div class="it-row" id="captcha">
			<label for="captcha-id"><?php echo t('captcha.security') ?></label>
			<div class="security">
				<img src="<?php echo Site::url('captcha') ?>" alt="" /><a href="javascript:;" title="<?php echo t('captcha.update') ?>"></a>
				<input type="text" name="captcha" id="captcha-id" value="" class="it-text" />
			</div>
			<div class="it-note"><?php echo t('captcha.notice') ?></div>
			<?php if ($error = Arr::path($errors, '_external.captcha')) : ?>
				<div class="it-error"><?php echo $error ?></div>
			<?php endif ?>
		</div>
	<?php endif ?>
	<div class="it-row last">
		<div class="links">
			<a href="<?php echo URL::site('forgot') ?>"><?php echo t('auth.forgot') ?></a>
			<a href="<?php echo URL::site('registr') ?>"><?php echo t('auth.registr') ?></a>
		</div>
		<input type="hidden" name="token" value="<?php echo Security::token() ?>" />
		<button type="submit" name="submit" value="1" class="it-button"><?php echo t('auth.signin') ?></button>
	</div>
    <?php endif ?>
</form>