(function(tinymce) {
	var DOM 	= tinymce.DOM,
		Event 	= tinymce.dom.Event,
		extend 	= tinymce.extend,
		each 	= tinymce.each,
		Cookie 	= tinymce.util.Cookie,
		explode = tinymce.explode;


	// Tell it to load theme specific language pack(s)
	tinymce.ThemeManager.requireLangPack('teenterra');

	tinymce.create('tinymce.themes.TeenTerraTheme', {

		// Control name lookup, format: title, command
		controls: {
			bold: 			['bold_desc', 			'Bold'],
			italic: 		['italic_desc', 		'Italic'],
			underline: 		['underline_desc', 		'Underline'],
			strikethrough: 	['striketrough_desc', 	'Strikethrough'],
			bullist: 		['bullist_desc', 		'InsertUnorderedList'],
			numlist: 		['numlist_desc', 		'InsertOrderedList'],
			undo: 			['undo_desc', 			'Undo'],
			redo: 			['redo_desc', 			'Redo'],
			link: 			['link_desc', 			'mceLink'],
			unlink: 		['unlink_desc', 		'unlink'],
			image: 			['image_desc', 			'mceImage'],
			cleanup: 		['cleanup_desc', 		'mceCleanup'],
			hr: 			['hr_desc', 			'InsertHorizontalRule'],
			removeformat: 	['removeformat_desc', 	'RemoveFormat'],
			sub: 			['sub_desc', 			'subscript'],
			sup: 			['sup_desc', 			'superscript'],
			charmap: 		['charmap_desc', 		'mceCharMap'],
			anchor: 		['anchor_desc', 		'mceInsertAnchor'],
			blockquote: 	['blockquote_desc', 	'mceBlockQuote']
		},

//		stateControls: ['bold', 'italic', 'underline', 'strikethrough', 'bullist', 'numlist', 'sub', 'sup', 'blockquote'],

		init: function(ed, url) {
			var t = this, s;


			t.editor = ed;
			t.url = url;
//			t.onResolveName = new tinymce.util.Dispatcher(t);
			s = ed.settings;

			if (!s.theme_toolbar1) {				s = extend({					theme_toolbar1: 'bold,italic,underline,strikethrough,|,bullist,numlist,|,sub,sup,|blockquote',
				}, s);			}

			t.settings = s = extend({
				theme_path: 				1,
				theme_blockformats: 		'p,h4,h5,h6',
				theme_resize_horizontal: 	1,
				theme_resizing_use_cookie: 	1,
				readonly: 					ed.settings.readonly
			}, s);

			if (ed.settings.content_css !== false)
				ed.contentCSS.push(ed.baseURI.toAbsolute(url + "/skins/" + ed.settings.skin + "/content.css"));

			// Init editor
//			ed.onInit.add(function() {
//				if (!ed.settings.readonly) {//					ed.onNodeChange.add(t._nodeChanged, t);
//					ed.onKeyUp.add(t._updateUndoStatus, t);
//					ed.onMouseUp.add(t._updateUndoStatus, t);
//					ed.dom.bind(ed.dom.getRoot(), 'dragend', function() {
//						t._updateUndoStatus(ed);
//					});
//				}
//			});

//			ed.onSetProgressState.add(function(ed, b, ti) {
//				var co, id = ed.id, tb;

//				if (b) {
//					t.progressTimer = setTimeout(function() {
//						co = ed.getContainer();
//						co = co.insertBefore(DOM.create('DIV', {style : 'position:relative'}), co.firstChild);
//						tb = DOM.get(ed.id + '_tbl');

//						DOM.add(co, 'div', {id : id + '_blocker', 'class' : 'mceBlocker', style : {width : tb.clientWidth + 2, height : tb.clientHeight + 2}});
//						DOM.add(co, 'div', {id : id + '_progress', 'class' : 'mceProgress', style : {left : tb.clientWidth / 2, top : tb.clientHeight / 2}});
//					}, ti || 0);
//				} else {
//					DOM.remove(id + '_blocker');
//					DOM.remove(id + '_progress');
//					clearTimeout(t.progressTimer);
//				}
//			});

			DOM.loadCSS(s.editor_css ? ed.documentBaseURI.toAbsolute(s.editor_css) : url + "/skins/" + ed.settings.skin + "/ui.css");
			if (s.skin_variant)
				DOM.loadCSS(url + "/skins/" + ed.settings.skin + "/ui_" + s.skin_variant + ".css");
		},

		renderUI: function(o) {
			var t = this, s = t.settings, ed = t.editor, cf = ed.controlManager, i, cs;
			var c = ed.settings.skin + 'Skin' + (s.skin_variant ? ' ' + ed.settings.skin + 'Skin' + t._ufirst(s.skin_variant) : '');

			var n = DOM.insertAfter(DOM.create('div', {id : ed.id + '_container', 'class' : 'mceEditor ' + c}), o.targetNode);

            // create toolbars
			if (!s.readonly) {
				for (i = 1; (cs = s['theme_toolbar' + i]); i++) {
					var tb = cf.createToolbar('toolbar' + i);
					each(explode(cs), function(c) {
						if ((c = t.controls[c]) && (c = cf.createButton(c[1], [0]))) tb.add(c);
						else if (c = cf.createControl(c)) tb.add(c);
					});
					tb.renderTo(n);
					console.log(tb);
            	}
			}
			var sc = DOM.add(n, 'div', {'class': 'mceLayout'});
            // create iframe container
			var ic = DOM.add(sc, 'div', {'class': 'mceIframeContainer'});

			// create statusbar
			if (!s.readonly) {            	DOM.add(n, 'div', {'class' : 'mceStatusbar'});			}

			return {
				iframeContainer: ic,
				editorContainer: ed.id + '_container',
				sizeContainer: sc,
				deltaHeight: 0
			};
		},

		getInfo : function() {
			return {
				longname : 'TeenTerra theme',
				author : 'TeenTerra Ltd.',
				authorurl : 'http://teenterra.com',
				version : tinymce.majorVersion + "." + tinymce.minorVersion
			}
		},

		_ufirst : function(s) {
			return s.substr(0, 1).toUpperCase() + s.substr(1);
		}
	});

	tinymce.ThemeManager.add('teenterra', tinymce.themes.TeenTerraTheme);
}(tinymce));
