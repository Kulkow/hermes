$(function() {
	$(window).resize(function() {
		$('tr:not(.group) td:not(.actions)').each(function() {
			var td = $(this);
			td.removeAttr('style');
			setTimeout(function() {
				td.width(td.width());
			}, 10);
		});
	}).triggerHandler('resize');

	var sortable = $('#sortable'), update = $('#sortable-update');

	sortable.sortable({
		items: 'tr:not(.sortable-exclude)',
		handle: '.sortable-handle',
		axis: 'y',
		update: function() {
			update.show();
		}
	});

	update.click(function() {
		it.ajax($(this).attr('href'), {data: sortable.sortable('toArray')}, function() {
			window.location = window.location;
		});
		return!1;
	});
});