<div class="it-row">
	<label for="data-id">Содержание</label>
	<div class="it-area"><textarea id="data-id" name="data" rows="15" class="it-editor"><?php echo Arr::get($_REQUEST, 'data') ?></textarea></div>
	<div class="it-notice">Содержимое блока, как оно будет показано пользователю</div>
</div>
<script src="/media/libs/tiny_mce/tiny_mce_gzip.js"></script>
<script src="/media/libs/tiny_mce/tiny_mce_init.js"></script>
<script src="/media/libs/it/js/it.editor.js"></script>
