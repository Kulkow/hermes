<?php if (Arr::get($_REQUEST, 'id')) : ?>
	<h1>Редактирование валюты &laquo;<?php echo Arr::get($_REQUEST, 'code') ?>&raquo;</h1>
<?php else : ?>
	<h1>Новая валюта</h1>
<?php endif ?>
<form action="" method="post" accept-charset="utf-8"  enctype="multipart/form-data">
	<div class="it-row">
		<label for="code-id"><?php echo t('currency.code') ?></label>
		<div class="it-text"><input type="text" id="code-id" name="code" value="<?php echo Arr::get($_REQUEST, 'code') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'code')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <div class="it-row">
		<label for="description-id"><?php echo t('currency.description') ?></label>
		<div class="it-textarea">
            <textarea name="description" rows="3" class="it-editor" id="content-id"><?php echo Arr::get($_REQUEST, 'description') ?></textarea>
        </div>    
		<?php if ($error = Arr::get($errors, 'description')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
	<div class="it-row">
        <input type="hidden" name="token" value="<?php echo Security::token() ?>" />
		<button type="submit" name="submit" value="1" class="it-button">Сохранить</button>
	</div>
</form>
