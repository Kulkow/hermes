<h1>Новый информационный блок</h1>
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
		<legend>Выберите модель блока</legend>
		<div class="it-row">
			<label for="block_text-id"><input type="radio" id="block_text-id" name="model" value="block_text" checked /><?php echo t('block.model.title') ?></label>
			<div class="it-notice"><?php echo t('block.model.description') ?></div>
		</div>
		<?php foreach (Module::get() as $module) : ?>
			<?php foreach ($module->blocks->block as $block) : ?>
				<div class="it-row">
					<label for="<?php echo $module->name ?>_block_<?php echo $block->name ?>-id"><input type="radio" id="<?php echo $module->name ?>_block_<?php echo $block->name ?>-id" name="model" value="<?php echo $module->name ?>_block_<?php echo $block->name ?>" /><?php echo $block->title ?> (<?php echo $module->title ?>)</label>
					<div class="it-notice"><?php echo $block->description ?></div>
				</div>
			<?php endforeach ?>
		<?php endforeach ?>
	</fieldset>
	<div class="it-row">
		<input type="hidden" name="hide" value="0" />
		<button type="submit" name="submit" value="1" class="it-button">Далее</button>
		<button type="button" name="cancel" class="it-button" data-url="/admin/block">Отмена</button>
	</div>
</form>