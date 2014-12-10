<? echo View::factory('user/money/top')->bind('menu_user',$menu_user); ?>
<h3>Пополнить через Qiwi</h3>
<?php if(! empty($send)) : ?>
<p>Ожидайте пополнения счета</p>
<? else: ?>
<form action="" method="post" accept-charset="utf-8" class="form">
    <?php if ($error = Arr::path($errors, 'create')) : ?>
			<div class="it-error"><?php echo $error ?></div>
	<?php endif ?>
    <? if(! $session_qiwi): ?>
        <div class="it-row">
    		<label for="summa-id"><?php echo t('qiwi.summa') ?></label>
    		<input type="text" class="it-text" id="summa-id" name="summa" value="<?php echo Arr::get($_REQUEST, 'summa') ?>" />
    		<?php if ($error = Arr::path($errors, 'summa')) : ?>
    			<div class="it-error"><?php echo $error ?></div>
    		<?php endif ?>
    	</div>
    <? else: ?>
       <div class="it-row">
       <? $curs = $bill->currency->curs('RUB'); $rub = ORM::factory('currency', array('code' => 'RUB')) ?>
            <h3>Оплатите <? echo ($bill->summa*$curs).$rub->render() ?>  на КИВИ КОШЕЛЕК <? echo $payment->login; ?></h3>
            
            <p><a href="https://visa.qiwi.ru/payment/form.action?provider=99" rel="nofollow" target="_blank">Для оплаты можете перейти по ссылке </a></p>
            <p>После оплаты введите номер телефона с которого вы оплатили, средства перечисляться на ваш счет в течении дня</p>
       </div>
        <div class="it-row">
    		<label for="phone-id"><?php echo t('qiwi.phone') ?></label>
    		<input type="text" class="it-text" id="phone-id" name="phone" value="<?php echo Arr::get($_REQUEST, 'phone') ?>" />
    		<?php if ($error = Arr::path($errors, 'phone')) : ?>
    			<div class="it-error"><?php echo $error ?></div>
    		<?php endif ?>
        </div>    
    <? endif ?>
    <? if(FALSE): ?>
    <div class="it-row">
		<label for="comment-id"><?php echo t('qiwi.comment') ?></label>
            <textarea name="comment" rows="2" class="it-area">
                <?php echo Arr::get($_REQUEST, 'comment') ?>
            </textarea>
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