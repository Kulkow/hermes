<h1>Шаблоны сайта</h1>
<form action="" method="post" accept-charset="utf-8">
	<?php foreach ($skins as $skin) : ?>
		<label for="<?php echo $skin['folder'] ?>" class="skin<?php if ($skin['folder'] == $site->skin) echo ' current' ?>">
			<input type="radio" name="skin" id="<?php echo $skin['folder'] ?>"<?php if ($skin['folder'] == $site->skin) echo ' checked' ?> value="<?php echo $skin['folder'] ?>" />
			<h4><?php echo $skin['name'] ?></h4>
			<div class="preview">
				<?php if ($skin['preview']) : ?>
					<img src="<?php echo $skin['preview'] ?>" alt="" />
				<?php endif ?>
			</div>
			<div class="description"><?php echo $skin['description'] ?></div>
		</label>
	<?php endforeach ?>
	<div class="it-row">
		<button type="submit" name="submit" value="1" class="it-button">Сохранить</button>
		<button type="button" name="cancel" class="it-button" data-url="/admin/config">Отмена</button>
	</div>
</form>
<script>
$(function() {
	var skins = $('.skin');
	$('input', skins).click(function() {
		skins.removeClass('current');
		$(this).parent().addClass('current');
	});
});
</script>