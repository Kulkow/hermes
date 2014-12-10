<h2><?php echo t('auth.activate') ?></h2>
<div class="block message">
	<div class="body">
		<?php echo t('auth.activate.message', array(':login' => $user->fullname())); ?>
	</div>
	<ul class="actions right">
		<a href="<?php echo URL::site('login') ?>"><?php echo t('auth.auth') ?></a>
		<a href="/<?php echo URL::site() ?>"><?php echo t('site.go.home') ?></a>
	</ul>
</div>
