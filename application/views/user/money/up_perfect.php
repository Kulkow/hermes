<? echo View::factory('user/money/top')->bind('menu_user',$menu_user); ?>
<h3>Пополнить через PERFECT Money</h3>
<?php if(! empty($send)) : ?>
<form action="<?php echo Arr::get($send, 'action'); ?>" method="POST" target="_blank">
<div class="it-row">
Сумма пополнения:<?php echo Arr::get($send, 'PAYMENT_AMOUNT').' '.Arr::get($send, 'PAYMENT_UNITS'); ?>
</div>
<input type="hidden" name="PAYEE_ACCOUNT" value="<?php echo Arr::get($send, 'PAYEE_ACCOUNT');?>" />
<input type="hidden" name="PAYEE_NAME" value="<?php echo Arr::get($send, 'PAYEE_NAME'); ?>" />
<input type="hidden" name="PAYMENT_ID" value="<?php echo Arr::get($send, 'PAYMENT_ID'); ?>" />
<input type="hidden" name="PAYMENT_AMOUNT" value="<?php echo Arr::get($send, 'PAYMENT_AMOUNT'); ?>" />
<input type="hidden" name="PAYMENT_UNITS" value="<?php echo Arr::get($send, 'PAYMENT_UNITS'); ?>" />
<input type="hidden" name="STATUS_URL" value="<?php echo Arr::get($send, 'STATUS_URL'); ?>" />
<input type="hidden" name="PAYMENT_URL" value="<?php echo Arr::get($send, 'PAYMENT_URL'); ?>" />
<input type="hidden" name="PAYMENT_URL_METHOD" value="<?php echo Arr::get($send, 'PAYMENT_URL_METHOD'); ?>" />
<input type="hidden" name="NOPAYMENT_URL" value="<?php echo Arr::get($send, 'NOPAYMENT_URL'); ?>" />
<input type="hidden" name="NOPAYMENT_URL_METHOD" value="<?php echo Arr::get($send, 'NOPAYMENT_URL_METHOD'); ?>" />
<input type="hidden" name="SUGGESTED_MEMO" value="<?php echo Arr::get($send, 'SUGGESTED_MEMO'); ?>" />
<input type="hidden" name="BAGGAGE_FIELDS" value="" />
<div class="it-row">
		<input type="submit" name="PAYMENT_METHOD" value="Оплатить" class="button it-button" />
</div>
</form>
<? else: ?>
<form action="" method="post" accept-charset="utf-8" class="form">
<? // print_r($errors) ?>
    <?php if ($error = Arr::path($errors, 'create')) : ?>
			<div class="it-error"><?php echo $error ?></div>
	<?php endif ?>
    <? if(FALSE): ?>
    <div class="it-row">
		<label for="phone-id"><?php echo t('perfect.phone') ?></label>
		<input type="text" class="it-text" id="phone-id" name="phone" value="<?php echo Arr::get($_REQUEST, 'phone') ?>" />
		<?php if ($error = Arr::path($errors, '_external.phone')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
    </div>
    <?php endif ?>
    <div class="it-row">
		<label for="summa-id"><?php echo t('perfect.summa') ?></label>
		<input type="text" class="it-text" id="summa-id" name="summa" value="<?php echo Arr::get($_REQUEST, 'summa') ?>" />
		<?php if ($error = Arr::path($errors, 'summa')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <? if(FALSE): ?>
    <div class="it-row">
		<label for="comment-id"><?php echo t('qiwi.comment') ?></label>
            <textarea name="comment" rows="2" class="it-area"><?php echo Arr::get($_REQUEST, 'comment') ?></textarea>
		<?php if ($error = Arr::path($errors, '_external.comment')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <? endif ?>
    <div class="it-row">
        <input type="hidden" name="token" value="<?php echo Security::token() ?>" />
		<button type="submit" name="submit" value="1" class="it-button">Пополнить</button>
	</div>
</form>
<?php endif ?>