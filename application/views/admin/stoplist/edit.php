<h1>Редактирование стоп-лист &laquo;<?php echo Arr::get($_REQUEST, 'id') ?>&raquo;</h1>
<form action="" method="post" accept-charset="utf-8">
    <div class="it-row">
		<label for="ip-id"><?php echo t('stoplist.ip') ?></label>
		<div class="it-text"><input type="text" id="ip-id" name="ip" value="<?php echo Arr::get($_REQUEST, 'ip'); ?>" /></div>
		<?php if ($error = Arr::get($errors, 'ip')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <div class="it-row">
		<label for="expires-id"><?php echo t('stoplist.expires') ?></label>
		<div class="it-text"><input type="text" id="expires-id" name="expires" value="<?php $expires = Arr::get($_REQUEST, 'expires', NULL); echo (intval($expires) > 0 ? date('d.m.Y H:i', intval($expires)) : "");  ?>" /></div>
		<?php if ($error = Arr::get($errors, 'expires')) : ?>
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

$('#expires-id').datetimepicker();
});
</script>				
