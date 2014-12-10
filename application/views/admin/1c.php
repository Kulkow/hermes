<h1>Новый запрос</h1>
<form action="" method="post" accept-charset="window-1251" id="form_c">
    <?php if(count($errors) > 0) : ?>
       <?php print_r($errors) ?> 
    <?php endif ?>
	<div class="it-row">
		<label for="card_id-id">Номер карты</label>
		<div class="it-text"><input type="text" id="card_id-id" name="card_id" value="<?php echo Arr::get($_REQUEST, 'card_id') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'card_id')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <div class="it-row">
		<label for="type-id">Тип операции</label>
		<div class="it-select">
            <select name="type_id">
                <?php foreach(ORM::factory('event_type')->find_all() as $type) : ?>
                    <option value="<?php echo $type->id ?>" <?php echo ($type->id == Arr::get($_REQUEST, 'type') ? 'selected="selected"' : '') ?>><?php echo $type->description ?></option>
                <?php endforeach ?>
            </select>
        </div>    
		<?php if ($error = Arr::get($errors, 'type_id')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <div class="it-row">
		<label for="code-id">code</label>
		<div class="it-text"><input type="text" id="code-id" name="code" value="<?php echo Arr::get($_REQUEST, 'code') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'code')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <div class="it-row">
		<label for="activate-id">activate</label>
		<div class="it-text"><input type="text" id="activate-id" name="activate" value="<?php echo Arr::get($_REQUEST, 'activate') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'activate')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <div class="it-row">
		<label for="phone-id">phone</label>
		<div class="it-text"><input type="text" id="phone-id" name="phone" value="<?php echo Arr::get($_REQUEST, 'phone') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'phone')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <div class="it-row">
		<label for="email-id">email</label>
		<div class="it-text"><input type="text" id="email-id" name="email" value="<?php echo Arr::get($_REQUEST, 'email') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'email')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <div class="it-row">
		<label for="ball-id">ball</label>
		<div class="it-text"><input type="text" id="ball-id" name="ball" value="<?php echo Arr::get($_REQUEST, 'ball') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'ball')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
	<div class="it-row">
        <?php if ($error = Arr::path($errors, '_external.hash')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>   
        <input type="hidden" name="hash" value="" />
        <!--<input type="hidden" name="token" value="<?php echo Security::token() ?>" />-->
		<button type="submit" name="submit" value="1" class="it-button">Сохранить</button>
        <button type="submit" name="generete" value="1" class="it-button">Генерировать ХЕШ</button>
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

$('#activate-id').datetimepicker();

$('[name=generete]').click(function(){
    console.log('out');
    var data = $('#form_c').serialize();
    console.log(data);
    $.ajax({
        type: "POST",
        data: data,
        url: "<?php echo Site::url('1C/generate_hash') ?>",
        cache: false,
        success: function(json){
        json = JSON.parse(json);
        if(! json.error)
        {
          var html = json.html;
          $('[name=hash]').val(html);
        }
        else
        {
          alert(json.error);
        }
      }
    });
    return !1;
})
});
</script>				
