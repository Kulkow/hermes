<?php if (Arr::get($_REQUEST, 'id')) : ?>
	<h1>Редактирование валюты &laquo;<?php echo Arr::get($_REQUEST, 'code') ?>&raquo;</h1>
<?php else : ?>
	<h1>Новый курс</h1>
<?php endif ?>
<? $currencys = ORM::factory('currency')->find_all(); ?>
<form action="" method="post" accept-charset="utf-8"  enctype="multipart/form-data">
   <div class="it-row">
       <div class="row-inline">
            <label for="value-id"><?php echo t('curs.value') ?></label>
       </div> 
       <div class="row-inline">
		  <div class="it-select">
             <? $_currency = Arr::get($_REQUEST, 'currency_id'); ?>
              <select name="currency_id">
              <? foreach($currencys as $currency): ?>
                    <option value="<? echo $currency->id ?>" <? echo ($currency->id == $_currency ? 'selected': '') ?>><? echo $currency->code ?></option>
              <? endforeach ?>
              </select>
          </div>
       </div>
       <div class="row-inline"> 
    		<div class="it-text"><input type="text" id="value-id" name="value" value="<?php echo Arr::get($_REQUEST, 'value') ?>" /></div>
    		<?php if ($error = Arr::get($errors, 'value')) : ?>
    			<div class="it-error"><?php echo $error ?></div>
    		<?php endif ?>
        </div>
        <div class="row-inline">
		  <div class="it-select">
             <? $_currency_eq = Arr::get($_REQUEST, 'currency_eq_id'); ?>
              <select name="currency_eq_id">
              <? foreach($currencys as $currency): ?>
                    <? if($currency->id != $_currency): ?> 
                    <option value="<? echo $currency->id ?>" <? echo ($currency->id == $_currency_eq ? 'selected': '') ?>><? echo $currency->code ?></option>
                    <? endif ?>
              <? endforeach ?>
              </select>
          </div>
       </div>
	</div>
	<div class="it-row">
        <input type="hidden" name="token" value="<?php echo Security::token() ?>" />
		<button type="submit" name="submit" value="1" class="it-button">Сохранить</button>
	</div>
</form>
<style>
.row-inline{float: left; margin: 0 15px 0 0; width: 250px;}
</style>
