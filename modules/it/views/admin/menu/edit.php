<?php if (Arr::get($_REQUEST, 'id')) : ?>
	<h1>Редактирование пункта меню &laquo;<span><?php echo Arr::get($_REQUEST, 'title') ?></span>&raquo;</h1>
<?php else : ?>
	<h1>Новый пункт меню</h1>
<?php endif ?>
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
        <?php if (Arr::get($_REQUEST, 'id')) : ?>
        <div class="it-row">
			<label for="url-id">Позиция</label>
			<div class="it-text"><input type="text" id="order-id" name="order" value="<?php echo Arr::get($_REQUEST, 'order') ?>" /></div>
			<?php if ($error = Arr::get($errors, 'order')) : ?>
				<div class="it-error"><?php echo $error ?></div>
			<?php endif ?>
		</div>
        <?php endif ?>
		<div class="it-row">
			<label for="url-id">URL</label>
			<div class="it-text"><input type="text" id="url-id" name="url" value="<?php echo Arr::get($_REQUEST, 'url') ?>" /></div>
			<?php if ($error = Arr::get($errors, 'url')) : ?>
				<div class="it-error"><?php echo $error ?></div>
			<?php endif ?>
		</div>
		<div class="it-row">
			<label for="group-id">Выберите группу меню</label>
			<div class="it-select">
				<select id="group-id" name="group">
					<option value=""></option>
					<?php foreach (Menu::groups() as $group) : ?>
						<option value="<?php echo $group ?>"<?php if ($group == Arr::get($_REQUEST, 'group')) echo ' selected'?>><?php echo $group ?></option>
					<?php endforeach ?>
				</select>
			</div>
			<label for="group-new-id">или задайте новую</label>
			<div class="it-text"><input type="text" id="group-new-id" name="group-new" value="<?php echo Arr::get($_REQUEST, 'group-new') ?>" /></div>
			<?php if ($error = Arr::get($errors, 'group')) : ?>
				<div class="it-error"><?php echo $error ?></div>
			<?php endif ?>
			<div class="it-notice">Наименование группы определяет шаблон для вывода меню: menu/_наименование_группы_</div>
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