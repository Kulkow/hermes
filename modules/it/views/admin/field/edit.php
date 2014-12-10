<h1>Редактирование поля &laquo;<span><?php echo Arr::get($_REQUEST, 'title') ?></span>&raquo; формы <?php echo t($form->object_name().'.type') ?> &laquo;<span><?php echo $form->title ?></span>&raquo;</h1>
<form action="" method="post" accept-charset="utf-8">
	<fieldset>
		<legend>Основные параметры</legend>
		<div class="it-row">
			<label for="title-id">Заголовок</label>
			<div class="it-text"><input type="text" id="title-id" name="title" value="<?php echo Arr::get($_REQUEST, 'title') ?>" /></div>
			<?php if ($error = Arr::get($errors, 'title')) : ?>
				<div class="it-error"><?php echo $error ?></div>
			<?php endif ?>
		</div>
		<div class="it-row">
			<label for="required-id"><input type="checkbox" id="required-id" name="required"<?php if (Arr::get($_REQUEST, 'required')) echo ' checked' ?> value="1" /> Обязательное поле</label>
		</div>
		<div class="it-row">
			<label for="notice-id">Пояснение к полю</label>
			<div class="it-text"><input type="text" id="notice-id" name="notice" value="<?php echo Arr::get($_REQUEST, 'notice') ?>" /></div>
			<?php if ($error = Arr::get($errors, 'notice')) : ?>
				<div class="it-error"><?php echo $error ?></div>
			<?php endif ?>
		</div>
	</fieldset>
	<fieldset>
		<legend>Параметры отображения</legend>
		<div class="it-row">
			<label for="class-id">Класс (CSS)</label>
			<div class="it-text"><input type="text" id="class-id" name="class" value="<?php echo Arr::get($_REQUEST, 'class') ?>" /></div>
		</div>
		<div class="it-row">
			<label for="hide-id"><input type="checkbox" id="hide-id" name="hide"<?php if ( ! Arr::get($_REQUEST, 'hide')) echo ' checked' ?> value="1" /> Показывать</label>
		</div>
		<div class="it-row">
			<label for="auth-0-id"><input type="radio" id="auth-0-id" name="auth" value="0"<?php if (Arr::get($_REQUEST, 'auth') == 0) echo ' checked' ?> />Для всех</label>
			<label for="auth-1-id"><input type="radio" id="auth-1-id" name="auth" value="1"<?php if (Arr::get($_REQUEST, 'auth') == 1) echo ' checked' ?> />Только для авторизованных</label>
			<label for="auth-2-id"><input type="radio" id="auth-2-id" name="auth" value="2"<?php if (Arr::get($_REQUEST, 'auth') == 2) echo ' checked' ?> />Только для неавторизованных</label>
		</div>
	</fieldset>
	<div class="it-row">
		<button type="submit" name="submit" value="1" class="it-button">Сохранить</button>
	</div>
</form>