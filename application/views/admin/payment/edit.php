<?php if (Arr::get($_REQUEST, 'id')) : ?>
	<h1>Редактирование способа оплаты &laquo;<?php echo Arr::get($_REQUEST, 'id') ?>&raquo;</h1>
<?php else : ?>
	<h1>Новая система оплаты</h1>
<?php endif ?>
<form action="" method="post" accept-charset="utf-8"  enctype="multipart/form-data">
    <div class="it-row">
		<label for="alias-id"><?php echo t('payment.alias') ?></label>
		<div class="it-text"><input type="text" id="alias-id" name="alias" value="<?php echo Arr::get($_REQUEST, 'alias') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'alias')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <div class="it-row">
		<label for="title-id"><?php echo t('payment.title') ?></label>
		<div class="it-text"><input type="text" id="title-id" name="title" value="<?php echo Arr::get($_REQUEST, 'title') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'title')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
     <div class="it-row">
		<label for="login-id"><?php echo t('payment.login') ?></label>
		<div class="it-text"><input type="text" id="login-id" name="login" value="<?php echo Arr::get($_REQUEST, 'login') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'login')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
     <div class="it-row">
		<label for="password-id"><?php echo t('payment.password') ?></label>
		<div class="it-text"><input type="password" id="password-id" name="password" value="<?php echo Arr::get($_REQUEST, 'password') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'password')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <div class="it-row">
		<label for="signature-id"><?php echo t('payment.signature') ?></label>
		<div class="it-text"><input type="text" id="signature-id" name="signature" value="<?php echo Arr::get($_REQUEST, 'signature') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'signature')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
	<div class="it-row">
        <input type="hidden" name="token" value="<?php echo Security::token() ?>" />
		<button type="submit" name="submit" value="1" class="it-button">Сохранить</button>
	</div>
</form>
