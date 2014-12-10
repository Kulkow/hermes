<?php if (Arr::get($_REQUEST, 'id')) : ?>
	<h1>Редактирование пользователя &laquo;<?php echo Arr::get($_REQUEST, 'login') ?>&raquo;</h1>
<?php else : ?>
	<h1>Новый пользователь</h1>
<?php endif ?>
<form action="" method="post" accept-charset="utf-8">
  <?php if (! Arr::get($_REQUEST, 'id', NULL)) : ?>
	<div class="it-row">
		<label for="login-id"><?php echo t('auth.login') ?></label>
		<div class="it-text"><input type="text" id="login-id" name="login" value="<?php echo Arr::get($_REQUEST, 'login') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'login')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
   <?php endif ?>
    <div class="it-row">
		<label for="password-id"><?php echo t('auth.password') ?></label>
        <span id="generate">Сгенерировать пароль</span>
		<input type="password" name="password" id="password-id" value="" class="it-text" />
		<?php if ($error = Arr::path($errors, '_external.password')) : ?><div class="it-error"><?php echo $error ?></div><?php endif ?>
		<label for="password-show-id" class="inline hidden"><input type="checkbox" name="password-show" id="password-show-id"<?php if (Arr::get($_REQUEST, 'password-show')) echo ' checked' ?>  value="1" /><?php echo t('auth.password.hint') ?></label>
		<div id="password-show" class="hidden"></div>
	</div>
    <div class="it-row">
		<label for="name-id"><?php echo t('auth.name') ?></label>
		<div class="it-text"><input type="text" id="name-id" name="name" value="<?php echo Arr::get($_REQUEST, 'name') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'name')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
	<div class="it-row">
		<label for="email-id"><?php echo t('auth.email') ?></label>
		<div class="it-text"><input type="text" id="email-id" name="email" value="<?php echo Arr::get($_REQUEST, 'email') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'email')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <div class="it-row">
		<label for="phone-id"><?php echo t('auth.phone') ?></label>
		<div class="it-text"><input type="text" id="phone-id" name="phone" value="<?php echo Arr::get($_REQUEST, 'phone') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'phone')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <div class="it-row">
		<label for="skype-id"><?php echo t('auth.skype') ?></label>
		<div class="it-text"><input type="text" id="skype-id" name="skype" value="<?php echo Arr::get($_REQUEST, 'skype') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'skype')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <div class="it-row">
		<label for="vk-id"><?php echo t('auth.vk') ?></label>
		<div class="it-text"><input type="text" id="vk-id" name="vk" value="<?php echo Arr::get($_REQUEST, 'vk') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'vk')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <div class="it-row">
		<label for="referral-id"><?php echo t('auth.referral') ?></label>
		<div class="it-text"><input type="text" id="referral-id" name="referral" value="<?php echo $referral//Arr::get($_REQUEST, 'referral') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'referral')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>  
    <? if(FALSE): ?>
     <div class="it-row">
		<label for="status-id"><?php echo t('auth.status') ?></label>
		<div class="it-select">
           <select name="status">
                <option value="" <?php echo (Arr::get($_REQUEST, 'status') == '' ? 'selected="selected"' : '') ?>>не активен</option>
                <option value="login" <?php echo (Arr::get($_REQUEST, 'status') == 'login' ? 'selected="selected"' : '') ?>>пользователь</option>
                <option value="admin" <?php echo (Arr::get($_REQUEST, 'status') == 'admin' ? 'selected="selected"' : '') ?>>админ</option>
           </select>
        </div>
		<?php if ($error = Arr::get($errors, 'status')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
   <? endif ?>
     <div class="it-row">
        <? //$roles = ORM::factory('Role')->find_all(); $iarray = array('login', 'admin'); 
        $user_key = array_keys($user_roles); ?>
        <? foreach($roles as $role): ?>
        <div class="it-check">
            <input id="addrolles-<? echo $role->id ?>" name="addrolles[]" type="checkbox" <? ?> value="<? echo $role->name ?>" <? echo (in_array($role->name, $user_key) ? 'checked="checked"' : '') ?> />
            <label for="addrolles-<? echo $role->id ?>"><?php echo $role->description ?></label>
        </div>
        <? endforeach  ?>
	    <?php if ($error = Arr::get($errors, 'addrolles')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    
    <div class="it-row">
		<label for="send_user-id"><?php echo t('auth.send_user') ?></label>
		<div class="it-check">
           <input type="checkbox" id="send_user-id" name="send_user" value="1" <?php echo Arr::get($_REQUEST, 'send_user', NULL) ? 'checked="checked"' : "" ?> />
        </div>
		<?php if ($error = Arr::get($errors, 'active_now')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <!--<div class="it-row">
		<label for="active_time-id"><?php echo t('card.active_time') ?></label>
		<div class="it-text"><input type="text" id="active_time-id" name="active_time" value="<?php echo Arr::get($_REQUEST, 'active_time') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'active_time')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <div class="it-row">
		<label for="active_now-id"><?php echo t('card.active_now') ?></label>
		<div class="it-check">
           <input type="checkbox" id="active_now-id" name="active_now" <?php echo Arr::get($_REQUEST, 'active_now', NULL) ? 'checked="checked"' : "" ?> />
        </div>
		<?php if ($error = Arr::get($errors, 'active_now')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>-->
	<div class="it-row">
        <input type="hidden" name="token" value="<?php echo Security::token() ?>" />
        <input type="hidden" name="id" value="<?php echo Arr::get($_REQUEST, 'id') ?>" />
		<button type="submit" name="submit" value="1" class="it-button">Сохранить</button>
	</div>
</form>
<!--
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

-->
<script>
$(function() {
	var input = $('#password-id'), trigger = $('#password-show-id'), div = $('#password-show');
	trigger.click(function(o, nofocus) {
		if (trigger.prop('checked')) {
			div.slideDown(100);
			input.bind('keyup', function() {
				div.text(input.val());
			}).triggerHandler('keyup');
		} else {
			div.slideUp(100);
			input.unbind('keyup');
		}
		if (!nofocus) input.focus();
	}).triggerHandler('click', 1);
	trigger.parent().show();
    
    var generate = function(){
        $.ajax({
           type: "POST",
           url: "<?php echo Site::url('admin/user/generate_pasword') ?>",
           cache: false,
           success: function(json){
            json = JSON.parse(json);
             if(! json.error)
             {
                 var html = json.html;
                 input.val(html);
             }
             else
             {
                alert(json.error);
             }
           }
         });
    }
    $('#generate').click(function(){
        generate();
        //trigger.click();
    })
    
});
</script>
<style>
 #generate {cursor: pointer; background: #000; color:#FFF;}
</style>
