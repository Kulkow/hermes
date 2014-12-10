<?php if (Arr::get($_REQUEST, 'id')) : ?>
	<h1>Редактирование страницы &laquo;<?php echo Arr::get($_REQUEST, 'title') ?>&raquo;</h1>
<?php else : ?>
	<h1>Новая страница</h1>
<?php endif ?>
<form action="" method="post" accept-charset="utf-8">
	<div class="it-row">
		<label for="h1-id">Заголовок (H1)</label>
		<div class="it-text"><input type="text" id="h1-id" name="h1" value="<?php echo Arr::get($_REQUEST, 'h1') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'h1')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
		<div class="it-notice">Задавать не обязательно</div>
	</div>
	<div class="it-row">
		<label for="teaser-id">Анонс</label>
		<div class="it-area"><textarea id="teaser-id" name="teaser" rows="5" class=""><?php echo Arr::get($_REQUEST, 'teaser') ?></textarea></div>
		<div class="it-notice">Используется для вывода списков.</div>
	</div>
	<div class="it-row">
		<label for="content-id">Содержание</label>
		<div class="it-area"><textarea id="content-id" name="content" rows="15" class="it-editor"><?php echo Arr::get($_REQUEST, 'content') ?></textarea></div>
	</div>
	<div class="it-row">
		<label for="title-id">Заголовок (title)</label>
		<div class="it-text"><input type="text" id="title-id" name="title" value="<?php echo Arr::get($_REQUEST, 'title') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'title')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
		<div class="it-notice">Может быть сформирован автоматически по h1 (максимум 70 символов)</div>
	</div>
	<div class="it-row">
		<label for="alias-id">Псевдоним (URL)</label>
		<div class="it-text"><input type="text" id="alias-id" name="alias" value="<?php echo Arr::get($_REQUEST, 'alias') ?>" /></div>
		<div class="it-notice">Может быть сформирован автоматически по title (транслитерация, максимум 100 символов)</div>
		<?php if ($error = Arr::get($errors, 'alias')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
	<div class="it-row">
		<label for="pid-id">Вложить в</label>
		<div class="it-select">
			<select id="pid-id" name="pid">
				<option value=""></option>
				<?php foreach ($tree as $page) : ?>
					<?php if ( ! in_array($page->id, $_REQUEST['children'])) : ?>
						<option value="<?php echo $page->id ?>"<?php if ($page->id == Arr::get($_REQUEST, 'pid')) echo ' selected'?>><div style="padding-left:<?php echo ($page->level - 1) * 20 ?>px"><?php echo $page->title ?></div></option>
					<?php endif ?>
				<?php endforeach ?>
			</select>
		</div>
	</div>
	<div class="it-row">
		<label for="hide-id"><input type="checkbox" id="hide-id" name="hide"<?php if ( ! Arr::get($_REQUEST, 'hide')) echo ' checked' ?> value="1" /> Показывать</label>
	</div>
	<div class="it-row">
		<label for="keywords-id">Ключевые слова (keywords)</label>
		<div class="it-text"><input type="text" id="keywords-id" name="keywords" value="<?php echo Arr::get($_REQUEST, 'keywords') ?>" /></div>
	</div>
	<div class="it-row">
		<label for="description-id">Описание (description)</label>
		<div class="it-text"><input type="text" id="description-id" name="description" value="<?php echo Arr::get($_REQUEST, 'description') ?>" /></div>
	</div>
	<div class="it-row">
		<label for="mid-id">Меню</label>
		<div class="it-select">
			<select id="mid-id" name="mid">
				<option value=""></option>
				<?php $optgroup = $group = NULL ?>
				<?php foreach (Menu::get() as $item) : ?>
					<?php if ($item->group != $group) : ?>
						<?php if ($optgroup) : ?>
							</optgroup>
						<?php endif ?>
						<optgroup label="<?php echo $group = $item->group ?>">
					<?php endif ?>
					<option value="<?php echo $item->id ?>"<?php if ($item->id == Arr::get($_REQUEST, 'mid')) echo ' selected'?>><?php echo $item->title ?></option>
				<?php endforeach ?>
				</optgroup>
			</select>
		</div>
	</div>
	<div class="it-row">
		<button type="submit" name="submit" value="1" class="it-button">Сохранить</button>
	</div>
</form>
<script type="text/javascript" src="/media/tinymce4/tinymce.min.js"></script>
<?php echo View::factory('tinymce')->set('selector','it-editor') ?>
<?php /*
<script src="/media/libs/tiny_mce/tiny_mce_gzip.js"></script>
<script src="/media/libs/tiny_mce/tiny_mce_init.js"></script>
<?php Media::cache('js') ?>
<script src="/media/libs/it/js/it.editor.js"></script>
<?php Media::close() ?>
*/ ?>


