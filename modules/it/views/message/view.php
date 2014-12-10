<?php if ($errors = Arr::get($messages, Message::ERROR)) : ?>
	<div class="messages errors">
		<?php foreach ($errors as $error) : ?>
			<p><?php echo $error->text ?></p>
		<?php endforeach ?>
	</div>
<?php endif ?>
<?php if ($notices = Arr::get($messages, Message::NOTICE)) : ?>
	<div class="messages notices">
		<?php foreach ($notices as $notice) : ?>
			<p><?php echo $notice->text ?></p>
		<?php endforeach ?>
	</div>
<?php endif ?>