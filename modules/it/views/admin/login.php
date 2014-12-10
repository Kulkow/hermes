<div id="login-form">
	<h1><?php echo t('auth.login') ?></h1>
	<form action="/admin" method="post" accept-charset="utf-8">
		<?php if ($error = Arr::get($errors, 'login')) : ?>
			<div class="it-row"><div class="it-error"><?php echo $error ?></div></div>
		<?php endif ?>
		<div class="it-row">
			<label for="login-id"><?php echo t('auth.login.email') ?></label>
			<div class="it-text">
				<input type="text" name="login" id="login-id" value="<?php echo HTML::chars(Arr::get($_REQUEST, 'login'))?>" />
			</div>
		</div>
		<div class="it-row">
			<label for="password-id"><?php echo t('auth.password') ?></label>
			<div class="it-text">
				<input type="password" name="password" id="password-id" value="" />
			</div>
		</div>
		<?php if ($captcha) : ?>
			<div class="it-row" id="captcha">
				<label for="captcha-id"><?php echo t('captcha.security') ?></label>
				<div class="security">
					<img src="/captcha" alt="" /><a href="javascript:;" title="<?php echo t('captcha.update') ?>"></a>
					<div class="it-text">
						<input type="text" name="captcha" id="captcha-id" value="" />
					</div>
				</div>
				<div class="it-notice"><?php echo t('captcha.notice') ?></div>
				<?php if ($error = Arr::get($errors, 'captcha')) : ?>
					<div class="it-error"><?php echo $error ?></div>
				<?php endif ?>
			</div>
		<?php endif ?>
		<div class="it-row">
			<div class="right">
				<button type="submit" name="submit" value="1" class="it-button"><?php echo t('auth.signin') ?></button>
			</div>
			<label for="remember-id" class="it-checkbox"><input type="checkbox" name="remember" id="remember-id"<?php if (Arr::get($_REQUEST, 'remember')) echo ' checked' ?> value="1" /><?php echo t('auth.remember') ?></label>
		</div>
	</form>
</div>