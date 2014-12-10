<? echo View::factory('user/money/top')->bind('menu_user',$menu_user); ?>
<h3>Вывести Perfect Money</h3>
<?php if(! empty($send)) : ?>
<?php Message::notice('Средства будут перечислены на ваш счет в ближайшее время');?>
<?php endif ?>
<? if(! empty($bills_out)):  ?>
    <h2>Ожидайте перевода</h2>
    <? foreach($bills_out as $bill): ?>
        <p><b><? echo $bill->id ?>.</b> <? echo $bill->summa.$bill->currency->render() ?>  на аккаунт <? echo $bill->akkaunt  ?></p>
    <? endforeach ?>
<? endif ?>
<form action="" method="post" accept-charset="utf-8" class="form">
    <?php if ($error = Arr::path($errors, 'create')) : ?> 
			<div class="it-error"><?php echo $error ?></div>
	<?php endif ?>
    <div class="it-row">
		<label for="akkaunt-id"><?php echo t('perfect.akkaunt') ?></label>
		<input type="text" class="it-text" id="akkaunt-id" name="akkaunt" value="<?php echo Arr::get($_REQUEST, 'akkaunt') ?>" />
		<?php if ($error = Arr::path($errors, 'akkaunt')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
    </div>
    <div class="it-row">
		<label for="summa-id"><?php echo t('perfect.summa') ?></label>
		<input type="text" class="it-text" id="summa-id" name="summa" value="<?php echo Arr::get($_REQUEST, 'summa') ?>" />
		<?php if ($error = Arr::path($errors, 'summa')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
        <?php if ($error = Arr::path($errors, '_external.summa')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <!--
    <div class="it-row">
		<label for="comment-id"><?php echo t('perfect.comment') ?></label>
            <textarea name="comment" rows="2" class="it-area">
                <?php echo Arr::get($_REQUEST, 'comment') ?>
            </textarea>
		<?php if ($error = Arr::path($errors, 'comment')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>-->
    <div class="it-row">
        <input type="hidden" name="token" value="<?php echo Security::token() ?>" />
		<button type="submit" name="submit" value="1" class="it-button">Вывести</button>
	</div>
</form>