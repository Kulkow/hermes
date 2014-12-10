<h1>Информация о сайте</h1>
<form action="" method="post" accept-charset="utf-8">
	<div class="it-row">
		<label for="name-id">Название сайта в title</label>
		<div class="it-text"><input type="text" id="name-id" name="name" value="<?php echo Arr::get($_REQUEST, 'name') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'name')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
	<div class="it-row">
		<label for="logo-id">Название сайта в шапке</label>
		<div class="it-text"><input type="text" id="logo-id" name="logo" value="<?php echo Arr::get($_REQUEST, 'logo') ?>" /></div>
		<div class="it-notice">По умолчанию устанавливается равным названию сайта в title</div>
	</div>
	<div class="it-row">
		<label for="slogan-id">Слоган</label>
		<div class="it-text"><input type="text" id="slogan-id" name="slogan" value="<?php echo Arr::get($_REQUEST, 'slogan') ?>" /></div>
	</div>
	<div class="it-row">
		<label for="brief-id">Краткое описание (бриф)</label>
		<div class="it-area"><textarea id="brief-id" name="brief" rows="5" class="it-editor"><?php echo Arr::get($_REQUEST, 'brief') ?></textarea></div>
	</div>
	<div class="it-row">
		<label for="content-id">Текст на главной странице</label>
		<div class="it-area"><textarea id="content-id" name="content" rows="15" class="it-editor"><?php echo Arr::get($_REQUEST, 'content') ?></textarea></div>
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
		<button type="submit" name="submit" value="1" class="it-button">Сохранить</button>
		<button type="button" name="cancel" class="it-button" data-url="/admin/config">Отмена</button>
	</div>
</form>
<script src="/media/libs/tiny_mce/tiny_mce_gzip.js"></script>
<script src="/media/libs/tiny_mce/tiny_mce_init.js"></script>
<script src="/media/libs/it/js/it.editor.js"></script>
