<h2><?php echo t('auth.forgot.sended') ?></h2>
<div class="block message">
	<div class="body">
		<?php echo t('auth.forgot.sended.message', $data_user) ?>
	</div>
	<div class="links">
		<a href="<?php echo URL::site() ?>"><?php echo t('site.go.home') ?></a>
	</div>
</div>
