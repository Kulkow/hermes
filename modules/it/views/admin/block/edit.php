<h1>Редактирование информационного блока &laquo;<span><?php echo Arr::get($_REQUEST, 'name') ?></span>&raquo;</h1>
<form action="" method="post" accept-charset="utf-8">
	<fieldset>
		<legend>Основные параметры</legend>
		<div class="it-row">
			<label for="name-id">Описание</label>
			<div class="it-text"><input type="text" id="name-id" name="name" value="<?php echo Arr::get($_REQUEST, 'name') ?>" /></div>
			<?php if ($error = Arr::get($errors, 'name')) : ?>
				<div class="it-error"><?php echo $error ?></div>
			<?php endif ?>
			<div class="it-notice">Краткое описание вашего блока, используется на <a href="/admin/block">странице обзора блоков</a></div>
		</div>
		<div class="it-row">
			<label for="group-id">Выберите позицию блока</label>
			<div class="it-select">
				<select id="group-id" name="group">
					<option value=""></option>
					<?php foreach (Block::groups() as $group) : ?>
						<option value="<?php echo $group ?>"<?php if ($group == Arr::get($_REQUEST, 'group')) echo ' selected'?>><?php echo $group ?></option>
					<?php endforeach ?>
				</select>
			</div>
			<label for="group-new-id">или задайте новую</label>
			<div class="it-text"><input type="text" id="group-new-id" name="group-new" value="<?php echo Arr::get($_REQUEST, 'group-new') ?>" /></div>
			<?php if ($error = Arr::get($errors, 'group')) : ?>
				<div class="it-error"><?php echo $error ?></div>
			<?php endif ?>
			<div class="it-notice">Позиция для вывода блока на странице, в шаблоне выводится как Block::render('позиция')</div>
		</div>
	</fieldset>
	<fieldset>
		<legend>Параметры специфичные для блока</legend>
		<div class="it-row">
			<label for="title-id">Заголовок</label>
			<div class="it-text"><input type="text" id="title-id" name="title" value="<?php echo Arr::get($_REQUEST, 'title') ?>" /></div>
			<div class="it-notice">Заголовок блока, как он будет показан пользователю</div>
		</div>
		<?php echo View::factory('admin/'.str_replace('_', '/', $block->model))->bind('errors', $errors) ?>
	</fieldset>
	<fieldset>
		<legend>Параметры отображения</legend>
		<div class="it-row">
			<label for="view-id">Шаблон блока</label>
				<div class="it-text"><input type="text" id="view-id" name="view" value="<?php echo Arr::path($_REQUEST, 'view') ?>" /></div>
		</div>
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
		<div class="it-row">
			<label for="show-0-id"><input type="radio" id="show-0-id" name="show" value="0"<?php if (Arr::get($_REQUEST, 'show') == 0) echo ' checked' ?> />Показывать на каждой странице кроме перечисленных</label>
			<label for="show-1-id"><input type="radio" id="show-1-id" name="show" value="1"<?php if (Arr::get($_REQUEST, 'show') == 1) echo ' checked' ?> />Показывать только на перечисленных страницах</label>
			<div class="it-area"><textarea name="condition" rows="5"><?php echo Arr::get($_REQUEST, 'condition') ?></textarea></div>
		</div>
	</fieldset>
	<div class="it-row">
		<button type="submit" name="submit" value="1" class="it-button">Сохранить</button>
		<button type="button" name="cancel" class="it-button" data-url="/admin/block">Отмена</button>
	</div>
</form>