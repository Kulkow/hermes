<h2><?php echo t('auth.password.new') ?></h2>
<div class="block message">
	<div class="body">
		<?php echo t('auth.password.new') ?>
        <div><?php echo t('auth.newpassword') ?>:<b><?php echo $password ?></b></div>
	</div>
	<ul class="actions right">
		<a href="<?php echo URL::site() ?>"><?php echo t('site.go.home') ?></a>
	</ul>
</div>