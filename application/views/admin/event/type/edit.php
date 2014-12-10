<?php if (Arr::get($_REQUEST, 'id')) : ?>
	<h1>Редактирование типа &laquo;<?php echo Arr::get($_REQUEST, 'id') ?>&raquo;</h1>
<?php else : ?>
	<h1>Новый тип</h1>
<?php endif ?>
<form action="" method="post" accept-charset="utf-8">
	<div class="it-row">
		<label for="code-id">code</label>
		<div class="it-text"><input type="text" id="code-id" name="code" value="<?php echo Arr::get($_REQUEST, 'code') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'code')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <div class="it-row">
		<label for="title-id">Выводиться на сайте</label>
		<div class="it-text"><input type="text" id="title-id" name="title" value="<?php echo Arr::get($_REQUEST, 'title') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'title')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <div class="it-row">
		<label for="description-id">description event</label>
		<div class="it-text"><input type="text" id="description-id" name="description" value="<?php echo Arr::get($_REQUEST, 'description') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'description')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
	<div class="it-row">
		<button type="submit" name="submit" value="1" class="it-button">Сохранить</button>
	</div>
</form>
