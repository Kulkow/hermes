var it = window.it = {}

it.alert = function (message, title)
{
	$.notifier.notice(title, message);
}
it.error = function (message, title)
{
	$.notifier.error(title, message);
}
it.lang = {'deleteConfirm' : 'Удалить ?',
           'deleteOk' : 'Удалено',
           'orderUpdate': 'сортировка сохранена',
           toggle : {'hide' : 'Скрыть',
                     'show' : 'Показать'
                    }
            }

/**
 * коллекция виджетов
 */
it.widget = {}
/**
 *
 */
it.each = function(elements, context, callback) {
	$(elements, context || $('body')).not('.it').each(function() {
		callback($(this).addClass('it'));
	});
}
/**
 * генерация уникального id
 */
it.genUId = function() {
	return +new Date();
}

String.prototype.parse = function(separator) {
	var result = {};
	$.each(this.split(separator || '&'), function(i, s) {
		var r = s.split('=');
		result[r[0]] = r[1];
	});
	return result;
}

it.selectable = function(on) {
	var body = $('body').css('-moz-user-select', on ? 'auto' : 'none');
	body[on ? 'unbind' : 'bind']('selectstart', function() {
		return!1;
	});
}

it.color =  {
	str2rgb: function(color) {
		var rgb = [0, 0, 0], l = color.length == 4 ? 1 : 2;
		for (var i in rgb) {
			rgb[i] = parseInt('0x' + color.substr(1 + i*l, l)) * (l == 1 ? 17 : 1);
		}
		return rgb;
	},
	rgb2str: function(rgb) {
		for (var i in rgb) {
			rgb[i] = (rgb[i] < 16 ? '0' : '') + rgb[i].toString(16);
		}
		return '#' + rgb.join('');
	},
	invert: function(color) {
		var rgb = it.color.str2rgb(color);
		for (var i in rgb) {
			rgb[i] = 255 - rgb[i];
		}
		return it.color.rgb2str(rgb);
	}
}

/**
 * обертка для ajax
 */
it.ajax = function(url, data, success, complete, cache) {
	if (url.indexOf('http://') != 0 && url.indexOf('https://') != 0)
		url = window.location.protocol + '//' + window.location.host + url;

    _error = function(response) {
   		it.error((response && response.error) ? response.error : 'System error');
    }

   	$.ajax({
   		url: url,
   		data: data || {},
    	type: 'post',
   		dataType: 'json',
   		success: function(response) {
   			if (!response || response.error) _error(response); else success && success(response);
    	},
   		error: _error,
   		complete: complete,
    	cache: !!cache
   	});
}

$(function() {
	//it.ie = $.browser.msie && $.browser.version < 9;
	//it.ie6 = it.ie && $.browser.version < 7;
    it.ie = !1;
    it.ie6 = !1;
	/**
	 * инициализация виджетов
	 */
	for (var name in it.widget) {
		var init = it.widget[name].init;
		$.isFunction(init) && init();
	}
});