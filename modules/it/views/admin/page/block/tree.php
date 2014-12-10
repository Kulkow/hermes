<div class="it-row">
	<label for="data-alias-id">Псевдоним родительской страницы</label>
	<div class="it-text"><input type="text" id="data-alias-id" name="data[alias]" value="<?php echo Arr::path($_REQUEST, 'data.alias') ?>" /></div>
	<div class="it-notice">Если не указан, будет выведено все дерево</div>
</div>