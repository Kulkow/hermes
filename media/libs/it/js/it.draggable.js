it.widget.add('draggable', {	make: function(options) {
		var self = this;
		$(options.handle || self).mousedown(function(e) {			it.disableSelection();
			var c = {x1: 0, y1: 0, x2: -self.outerWidth(), y2: -self.outerHeight()};
			if (options.containment == 'parent') {
				var containment = self.parent(), pos = containment.offset();
				c.x1 = pos.left; c.y1 = pos.top; c.x2 += containment.width(); c.y2 += containment.height();
			} else {
				var containment = document.body.parentNode;
				c.x2 += containment.scrollWidth; c.y2 += containment.scrollHeight;
			}
			$('body').bind('mousemove.it-draggable', function(cur) {				var dx = cur.pageX - e.pageX, dy = cur.pageY - e.pageY;
				self.css({
					left: dx < c.x1 ? c.x1 : dx > c.x2 ? c.x2 : dx,
					top:  dy < c.y1 ? c.y1 : dy > c.y2 ? c.y2 : dy
				});
			}).one('mouseup', function() {
				$('body').unbind('.it-draggable');
				it.enableSelection();
			});
			return!1;
		});
		return self;
	}
});
