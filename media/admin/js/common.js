$(function() {
	$('a.ico.del').click(function() {
		if (confirm(it.lang.deleteConfirm)) {
			var a = $(this);
			it.ajax(a.attr('href'), {}, function(response) {
                a.parents('tr').remove();
				tableRefresh();
				it.alert(it.lang.deleteOk);
			});
		}
		return!1;
	});
	$('a.ico.hide').click(function() {
		var a = $(this);
		it.ajax(a.attr('href'), {}, function(response) {
			a.parents('tr')[response.hide ? 'removeClass' : 'addClass']('hide');
			it.alert(it.lang.toggle[response.hide]);
		});
		return!1;
	});
	$('button[name=cancel]').click(function() {
		window.location = $(this).data('url');
	});

	var order = $('#order-list');
	if (order.length) {
		var update = $('#order-update').click(function() {
			it.ajax(update.attr('href'), {data: order.sortable('toArray')}, function() {
				tableRefresh();
    			it.alert(it.lang.orderUpdate);
    			update.hide();
			});
			return!1;
		});

		$(window).resize(function() {
			$('tr:not(.group) td:not(.actions)', order).each(function() {
				var td = $(this);
				td.removeAttr('style');
				setTimeout(function() {
					td.width(td.width());
				}, 10);
			});
		}).triggerHandler('resize');

		order.sortable({
			items: 'tr:not(.order-exclude)',
			handle: '.order-handle',
			axis: 'y',
			update: function() {
				update.show();
			}
		});
	}

	function tableRefresh() {
		$('tr.group', order || $('body')).each(function() {
			var tr = $(this), next = tr.next('tr');
			if (!next.length || next.is('.group')) tr.remove();
		});
	}

});