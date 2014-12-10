<? echo View::factory('user/money/top')->bind('menu_user',$menu_user); ?>
<h3>Пополнить через Perfekt Money</h3>
<?php if(! empty($send)) : ?>
<?php Message::notice('<a href="">для оплаты перейдите по адресу </a>');?>
<?php endif ?>
<form action="" method="post" accept-charset="utf-8" class="form">
    <?php if ($error = Arr::path($errors, 'create')) : ?>
			<div class="it-error"><?php echo $error ?></div>
	<?php endif ?>
    <div class="it-row">
		<label for="phone-id"><?php echo t('qiwi.phone') ?></label>
		<input type="text" class="it-text" id="phone-id" name="phone" value="<?php echo Arr::get($_REQUEST, 'phone') ?>" />
		<?php if ($error = Arr::path($errors, '_external.phone')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
    </div>
    <div class="it-row">
		<label for="summa-id"><?php echo t('qiwi.summa') ?></label>
		<input type="text" class="it-text" id="summa-id" name="summa" value="<?php echo Arr::get($_REQUEST, 'summa') ?>" />
		<?php if ($error = Arr::path($errors, '_external.summa')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <div class="it-row">
		<label for="comment-id"><?php echo t('qiwi.comment') ?></label>
            <textarea name="comment" rows="2" class="it-area">
                <?php echo Arr::get($_REQUEST, 'comment') ?>
            </textarea>
		<?php if ($error = Arr::path($errors, '_external.comment')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <div class="it-row">
        <input type="hidden" name="token" value="<?php echo Security::token() ?>" />
		<button type="submit" name="submit" value="1" class="it-button">Пополнить</button>
	</div>
</form>