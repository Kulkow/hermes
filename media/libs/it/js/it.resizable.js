it.widge.addt('resizable', {
		var self = this;
		$(options.handle || self).mousedown(function(e) {
			$('body').bind('mousemove.it-resizable', function(cur) {
				options.vert && self.height(Match.max(h = self.height() + cur.pageY - e.pageY, options.maxHeight));
			}).one('mouseup', function() {
				$('body').unbind('.it-resizable');
				it.enableSelection();
			});
			return!1;
		});
		return self;
	},
	defaults: {
		minHeight: 10,
		horz: 1,
		vert: 1
});