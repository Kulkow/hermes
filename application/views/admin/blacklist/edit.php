<h1>Редактирование черного списка &laquo;<?php echo Arr::get($_REQUEST, 'id') ?>&raquo;</h1>
<form action="" method="post" accept-charset="utf-8">
    <div class="it-row">
		<label for="ip-id"><?php echo t('black.ip') ?></label>
		<div class="it-text"><input type="text" id="ip-id" name="ip" value="<?php echo Arr::get($_REQUEST, 'ip'); ?>" /></div>
		<?php if ($error = Arr::get($errors, 'ip')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <div class="it-row">
		<label for="active-id"><?php echo t('stoplist.active') ?></label>
		<div class="it-checkbox">
           <input type="checkbox" id="active-id" name="active" <?php echo (Arr::get($_REQUEST, 'active', NULL) ? 'checked="checked"' : ''); ?> value="1" /></div>
		<?php if ($error = Arr::get($errors, 'active')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
	<div class="it-row">
		<button type="submit" name="submit" value="1" class="it-button">Сохранить</button>
	</div>
</form>
