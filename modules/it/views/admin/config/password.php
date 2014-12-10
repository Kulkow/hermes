<h1>Пароль администратора</h1>
<form action="" method="post" accept-charset="utf-8">
	<div class="it-row">
		<label for="password-old-id">Текущий пароль</label>
		<div class="it-text"><input type="password" id="password-old-id" name="password-old" value="" /></div>
		<?php if ($error = Arr::get($errors, 'password-old')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
	<div class="it-row">
		<label for="password-new-id">Новый пароль</label>
		<div class="it-text"><input type="password" id="password-new-id" name="password-new" value="" /></div>
		<?php if ($error = Arr::get($errors, 'password-new')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
	<div class="it-row">
		<button type="submit" name="submit" value="1" class="it-button">Сохранить</button>
		<button type="button" name="cancel" class="it-button" data-url="/admin/config">Отмена</button>
	</div>
</form>