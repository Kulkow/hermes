<h1>Редактирование карты &laquo;<?php echo Arr::get($_REQUEST, 'code') ?>&raquo;</h1>
<form action="" method="post" accept-charset="utf-8">
 <?php if (count($errors) > 0) : ?>
    <? print_r($errors) ?>
 <? endif ?>
 <?php // $active = Arr::get($_REQUEST, 'active', NULL) ?>
    
        <div class="it-row">
    		<label for="active_time-id"><?php echo t('card.active_time') ?></label>
    		<div class="it-text"><input type="text" id="active_time-id" name="active_time" value="<?php $active_time = Arr::get($_REQUEST, 'active_time', NULL); echo (intval($active_time) > 0 ? date('d.m.Y H:i', intval($active_time)) : "");  ?>" /></div>
    		<?php if ($error = Arr::get($errors, 'active_time')) : ?>
    			<div class="it-error"><?php echo $error ?></div>
    		<?php endif ?>
    	</div>
      <div class="it-row">
		<label for="active-id"><input type="checkbox" id="active-id" name="active"<?php if (Arr::get($_REQUEST, 'active')) echo ' checked' ?> value="1" /> Активна</label>
	</div>
    <div class="it-row">
		<label for="activation-id"><input type="checkbox" id="activation-id" name="activation"<?php if (Arr::get($_REQUEST, 'activation')) echo ' checked' ?> value="1" /> Активировать с текущего момента</label>
	</div>
    
    <div class="it-row">
		<label for="ball-id"><?php echo t('card.ball') ?></label>
		<div class="it-text"><input type="text" id="ball-id" name="ball" value="<?php echo Arr::get($_REQUEST, 'ball') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'ball')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <? $currencys = ORM::factory('currency')->find_all(); ?>
     <div class="it-row">
		<label for="percent-id"><?php echo t('card.currency') ?></label>
		<div class="it-select">
        <? $_currency = Arr::get($_REQUEST, 'currency_id'); ?>
              <select name="currency_id">
              <? foreach($currencys as $currency): ?>
                    <option value="<? echo $currency->id ?>" <? echo ($currency->id == $_currency ? 'selected': '') ?>><? echo $currency->code ?></option>
              <? endforeach ?>
              </select>
		<?php if ($error = Arr::get($errors, 'currency_id')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <? $tarifs = ORM::factory('tarif')->find_all(); ?>
     <div class="it-row">
		<label for="percent-id"><?php echo t('card.tarif') ?></label>
		<div class="it-select">
        <? $_currency = Arr::get($_REQUEST, 'tarif_id'); ?>
              <select name="tarif_id">
              <? foreach($tarifs as $tarif): ?>
                    <option value="<? echo $tarif->id ?>" <? echo ($tarif->id == $_currency ? 'selected': '') ?>><? echo $tarif->h1 ?></option>
              <? endforeach ?>
              </select>
		<?php if ($error = Arr::get($errors, 'tarif')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
        </div>    
	</div>
    <div class="it-row">
		<label for="calc_tarif-id"><input type="checkbox" id="calc_tarif-id" name="calc_tarif" <?php if (Arr::get($_REQUEST, 'calc_tarif')) echo ' checked' ?> value="1" />Установить в зависимости от баланса</label>
	</div>
    <div class="it-row">
		<label for="percent-id"><?php echo t('card.percent') ?></label>
		<div class="it-text"><input type="text" id="percent-id" name="percent" value="<?php echo Arr::get($_REQUEST, 'percent') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'percent')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
	<div class="it-row">
		<button type="submit" name="submit" value="1" class="it-button">Сохранить</button>
	</div>
</form>
<link rel="stylesheet" href="/media/jqueryui/css/custom-theme/jquery-ui-1.9.2.custom.min.css" />
<script src="/media/jqueryui/js/jquery-ui-1.9.2.custom.min.js"></script>
<link rel="stylesheet" href="/media/jqueryui/addons/jquery-ui-timepicker-addon.css" />
<script src="/media/jqueryui/addons/jquery-ui-timepicker-addon.js"></script>
<script>
$(function() {
$.datepicker.regional['ru'] = {
	closeText: 'Закрыть',
	prevText: '<Пред',
	nextText: 'След>',
	currentText: 'Сегодня',
	monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
	'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
	monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
	'Июл','Авг','Сен','Окт','Ноя','Дек'],
	dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
	dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
	dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
	weekHeader: 'Не',
	dateFormat: 'dd.mm.yy',
	firstDay: 1,
	isRTL: false,
	showMonthAfterYear: false,
	yearSuffix: ''
};
$.datepicker.setDefaults($.datepicker.regional['ru']);
$.timepicker.regional['ru'] = {
	timeOnlyTitle: 'Выберите время',
	timeText: 'Время',
	hourText: 'Часы',
	minuteText: 'Минуты',
	secondText: 'Секунды',
	millisecText: 'Миллисекунды',
	timezoneText: 'Часовой пояс',
	currentText: 'Сейчас',
	closeText: 'Закрыть',
	timeFormat: 'HH:mm',
	amNames: ['AM', 'A'],
	pmNames: ['PM', 'P'],
	isRTL: false
};
$.timepicker.setDefaults($.timepicker.regional['ru']);

$('#active_time-id').datetimepicker();
});
</script>				
