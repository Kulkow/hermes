<h1>Новое поле формы <?php echo t($form->object_name().'.type') ?> &laquo;<span><?php echo $form->title ?></span>&raquo;</h1>
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
			<label for="type-id">Тип поля</label>
			<div class="it-select">
				<select id="type-id" name="type">
					<?php foreach (array_keys(Field::$types) as $type) : ?>
						<option value="<?php echo $type ?>"<?php if ($type == Arr::get($_REQUEST, 'type')) echo ' selected'?>><?php echo t('field.type.'.$type) ?></option>
					<?php endforeach ?>
				</select>
			</div>
	</fieldset>
	<div class="it-row">
		<input type="hidden" name="hide" value="0" />
		<button type="submit" name="submit" value="1" class="it-button">Далее</button>
		<button type="button" name="cancel" value="1" class="it-button" data-url="/admin/field<?php echo URL::query() ?>">Отмена</button>
	</div>
</form>