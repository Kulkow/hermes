<? echo View::factory('user/money/top')->bind('menu_user',$menu_user); ?>
<h3>Вывести через Qiwi</h3>
<? if(! empty($bills_out)):  ?>
    <h2>Ожидайте перевода</h2>
    <? foreach($bills_out as $bill): ?>
        <p><b><? echo $bill->id ?>.</b> <? echo $bill->summa.$bill->currency->render() ?>  на <? echo $bill->phone  ?></p>
    <? endforeach ?>
<? endif ?>
<?php if(! empty($send)) : ?>
<p> Средства будут перечислены на ваш счет в ближайшее время</p>
<? else: ?>
<form action="" method="post" accept-charset="utf-8" class="form">
    <?php if ($error = Arr::path($errors, 'create')) : ?>
			<div class="it-error"><?php echo $error ?></div>
	<?php endif ?>
    <div class="it-row">
		<label for="phone-id"><?php echo t('qiwi.phone') ?></label>
		<input type="text" class="it-text" id="phone-id" name="phone" value="<?php echo Arr::get($_REQUEST, 'phone') ?>" />
		<?php if ($error = Arr::path($errors, 'phone')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
    </div>
    <div class="it-row">
		<label for="summa-id"><?php echo t('qiwi.summa') ?></label>
		<input type="text" class="it-text" id="summa-id" name="summa" value="<?php echo Arr::get($_REQUEST, 'summa') ?>" />
		<?php if ($error = Arr::path($errors, 'summa')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <div class="it-row">
		<label for="comment-id"><?php echo t('qiwi.comment') ?></label>
            <textarea name="comment" rows="2" class="it-area">
                <?php echo Arr::get($_REQUEST, 'comment') ?>
            </textarea>
		<?php if ($error = Arr::path($errors, 'comment')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <div class="it-row">
        <input type="hidden" name="token" value="<?php echo Security::token() ?>" />
		<button type="submit" name="submit" value="1" class="it-button">Вывести</button>
	</div>
</form>
<?php endif ?>