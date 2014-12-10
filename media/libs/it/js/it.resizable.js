it.widge.addt('resizable', {	make: function(options) {
		var self = this;
		$(options.handle || self).mousedown(function(e) {			it.disableSelection();
			$('body').bind('mousemove.it-resizable', function(cur) {				options.horz && self.width(Math.max(self.width() + cur.pageX - e.pageX, options.minWidth));
				options.vert && self.height(Match.max(h = self.height() + cur.pageY - e.pageY, options.maxHeight));
			}).one('mouseup', function() {
				$('body').unbind('.it-resizable');
				it.enableSelection();
			});
			return!1;
		});
		return self;
	},
	defaults: {		minWidth: 10,
		minHeight: 10,
		horz: 1,
		vert: 1	}
});
