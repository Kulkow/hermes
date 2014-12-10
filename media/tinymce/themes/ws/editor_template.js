(function(tinymce) {
	var DOM 	= tinymce.DOM,
		Event 	= tinymce.dom.Event,
		extend 	= tinymce.extend,
		each 	= tinymce.each,
		Cookie 	= tinymce.util.Cookie,
		explode = tinymce.explode;


	// Tell it to load theme specific language pack(s)
	tinymce.ThemeManager.requireLangPack('ws');

	tinymce.create('tinymce.themes.wsTheme', {

		// Control name lookup, format: title, command
		controls: {
			bold: 			['bold_desc', 			'Bold'],
			italic: 		['italic_desc', 		'Italic'],
			underline: 		['underline_desc', 		'Underline'],
			strikethrough: 	['striketrough_desc', 	'Strikethrough'],
			bullist: 		['bullist_desc', 		'InsertUnorderedList'],
			numlist: 		['numlist_desc', 		'InsertOrderedList'],
			blockquote: 	['blockquote_desc', 	'mceBlockQuote'],
			link: 			['link_desc', 			'mceLink'],
			unlink: 		['unlink_desc', 		'unlink'],
			anchor: 		['anchor_desc', 		'mceInsertAnchor'],
			image: 			['image_desc', 			'mceImage'],
			media:			['media_desc', 			'mceMedia'],
			hr: 			['hr_desc', 			'InsertHorizontalRule'],
			sup: 			['sup_desc', 			'superscript'],
			sub: 			['sub_desc', 			'subscript'],
			charmap: 		['charmap_desc', 		'mceCharMap']
		},

		stateControls: ['bold', 'italic', 'underline', 'strikethrough', 'bullist', 'numlist', 'blockquote', 'sup', 'sub'],
		stateListBoxs: ['formatblock'],

		init: function(ed, url) {
			var t = this, s;

			t.editor = ed;
			t.url = url;
			t.onResolveName = new tinymce.util.Dispatcher(this);
			s = ed.settings;

			if (!s.theme_toolbar1) {				s = extend({					theme_toolbar1: 'bold,italic,underline,strikethrough,|,formatblock,|,bullist,numlist,blockquote,|,link,unlink,anchor,image,media,hr,|,sup,sub,|,charmap,|,clean',
//					theme_toolbar2: 'link,unlink,anchor,image,video,hr,|,clean,|,check,|,break'
				}, s);			}

			t.settings = s = extend({
				theme_path: 				1,
				theme_blockformats: 		'p,h4,h5,h6,div',
				theme_resize_horizontal: 	0,
				theme_resizing_use_cookie: 	1,
				readonly: 					ed.settings.readonly
			}, s);

			if (ed.settings.content_css !== false)
				ed.contentCSS.push(ed.baseURI.toAbsolute(url + "/skins/" + ed.settings.skin + "/content.css"));

			// Init editor
			if (!ed.settings.readonly)
				ed.onInit.add(function() {
					ed.onNodeChange.add(t._nodeChanged, t);
//					ed.onKeyUp.add(t._updateUndoStatus, t);
//					ed.onMouseUp.add(t._updateUndoStatus, t);
//					ed.dom.bind(ed.dom.getRoot(), 'dragend', function() {
//						t._updateUndoStatus(ed);
//					});
		            tinymce.dom.Event.add(ed.getBody(), 'focus', function(e) {
        		        t.layout.className = 'mceLayout focus';
		            });
		            tinymce.dom.Event.add(ed.getBody(), 'blur', function(e) {
        		        t.layout.className = 'mceLayout';
        		    });
				});

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
			var t = this, s = t.settings, ed = t.editor, cf = ed.controlManager, i, cs, a;
			var c = ed.settings.skin + 'Skin' + (s.skin_variant ? ' ' + ed.settings.skin + 'Skin' + t._ufirst(s.skin_variant) : '');

			var n = DOM.insertAfter(DOM.create('div', {id : ed.id + '_container', 'class' : 'mceEditor ' + c}), o.targetNode);

            // create toolbars
			if (!s.readonly) {
				for (i = 1; (cs = s['theme_toolbar' + i]); i++) {
					var tb = cf.createToolbar('toolbar' + i);
					each(explode(cs), function(c) {
                        if (c = t.createControl(c, cf)) tb.add(c);
					});
					tb.renderTo(n);
            	}
            	setTimeout(function() {
            		each(['formatblock', 'clean', 'spellchecker'], function(c) {            			if (a = DOM.get(ed.id + '_' + c + '_text')) {
		            		DOM.addClass(a, 'mceButton mceButtonEnabled');
		            		if (c != 'formatblock') DOM.setHTML(a, '<span class="mceIcon mce_' + c + '"></span>');
    		        	}
        	    	});
            	}, 10);
			}
			var sc = t.layout = DOM.add(n, 'div', {'class': 'mceLayout'});
            // create iframe container
			var ic = DOM.add(sc, 'div', {'class': 'mceIframeContainer'});

			// create statusbar
			if (!s.readonly) {            	DOM.add(n, 'div', {'class' : 'mceStatusbar'});			}

			ed.onKeyDown.add(function(ed, evt) {
				var DOM_VK_F10 = 121, DOM_VK_F12 = 123;

				if (evt.altKey) {
		 			if (evt.keyCode === DOM_VK_F10) {		 				ed.execCommand('mceFullScreen');
						return Event.cancel(evt);
					}
					else if (evt.keyCode === DOM_VK_F12) {						ed.execCommand('mceCodeEditor');						return Event.cancel(evt);
					}


//					else if (evt.keyCode === DOM_VK_F11) {
//						DOM.get(ed.id + '_path_row').focus();
//						return Event.cancel(evt);
//					}
				}
			});

			return {
				iframeContainer: ic,
				editorContainer: ed.id + '_container',
				sizeContainer: sc,
				deltaHeight: 0
			};
		},

		createControl: function(c, cf) {			var r;

			if (r = cf.createControl(c)) return r;
            switch (c) {            	case 'formatblock':
            		return this._createFormatBlock();

            	case 'clean':
            		return this._createClean();
            }

			if (r = this.controls[c])
				return cf.createButton(c, {title: "ws." + r[0], cmd: r[1], ui: r[2], value: r[3]});
		},

		getInfo : function() {
			return {
				longname : 'ws theme',
				author : 'k2fl',
				authorurl : '',
				version : tinymce.majorVersion + "." + tinymce.minorVersion
			}
		},

		execCommand : function(cmd, ui, val) {
			var f = this['_' + cmd];

			if (f) {
				f.call(this, ui, val);
				return true;
			}

			return false;
		},

		_createFormatBlock : function() {
			var c, fmts = {
				p: 'ws.paragraph',
				h4: 'ws.h4',
				h5: 'ws.h5',
				h6: 'ws.h6',
				div: 'ws.div'
			}, t = this;

			c = t.editor.controlManager.createListBox('formatblock', {title : 'ws.formatblock', onselect : function(v) {
				t.editor.execCommand('FormatBlock', false, v);
				return false;
			}});


			if (c) {
				each(t.editor.getParam('theme_blockformats', t.settings.theme_blockformats, 'hash'), function(v, k) {
					c.add(t.editor.translate(k != v ? k : fmts[v]), v, {'class' : 'mce_' + v});
				});
			}

			return c;
		},

        _createClean: function() {
        	var c, clean = {        		cleanup: 		['ws.cleanup_desc', 'mceCleanup'],
        		removeformat: 	['ws.removeformat_desc', 'RemoveFormat']        	}, t = this;
			c = t.editor.controlManager.createListBox('clean', {title : 'ws.clean_desc', onselect : function(v) {
				t.editor.execCommand(v[1]);
				console.log(v);
				return false;
			}});

			if (c) {
				each(clean, function(v, k) {
					c.add(t.editor.translate(v[0]), v, {'class' : 'mce_' + k});
				});
			}

			return c;
        },

		_ufirst : function(s) {
			return s.substr(0, 1).toUpperCase() + s.substr(1);
		},

		_nodeChanged : function(ed, cm, n, co, ob) {
			var t = this, p, de = 0, v, c, s = t.settings, cl, fz, fn, fc, bc, formatNames, matches;

			tinymce.each(t.stateControls, function(c) {
				cm.setActive(c, ed.queryCommandState(t.controls[c][1]));
			});

			function getParent(name) {
				var i, parents = ob.parents, func = name;

				if (typeof(name) == 'string') {
					func = function(node) {
						return node.nodeName == name;
					};
				}

				for (i = 0; i < parents.length; i++) {
					if (func(parents[i]))
						return parents[i];
				}
			};

			p = getParent('A');
			if (c = cm.get('link')) {
				c.setDisabled((!p && co) || (p && !p.href));
				c.setActive(!!p && (!p.name && !p.id));
			}

			if (c = cm.get('unlink')) {
				c.setDisabled(!p && co);
				c.setActive(!!p && !p.name && !p.id);
			}

			if (c = cm.get('anchor')) {
				c.setActive(!co && !!p && (p.name || (p.id && !p.href)));
			}

			p = getParent('IMG');
			if (c = cm.get('image'))
				c.setActive(!co && !!p && n.className.indexOf('mceItem') == -1);

			if (c = cm.get('formatblock')) {
				if (p = getParent(ed.dom.isBlock)) {	          		c.select(p.nodeName.toLowerCase());
	        		DOM.setHTML(DOM.get(ed.id + '_formatblock_text'), '<span class="mceIcon mce_' + p.tagName.toLowerCase() + '"></span>');
				}
			}

/*			if (s.theme_path) {
				p = DOM.get(ed.id + '_path') || DOM.add(ed.id + '_path_row', 'span', {id : ed.id + '_path'});

				if (t.statusKeyboardNavigation) {
					t.statusKeyboardNavigation.destroy();
					t.statusKeyboardNavigation = null;
				}

				DOM.setHTML(p, '');

				getParent(function(n) {
					var na = n.nodeName.toLowerCase(), u, pi, ti = '';

					// Ignore non element and bogus/hidden elements
					if (n.nodeType != 1 || na === 'br' || n.getAttribute('data-mce-bogus') || DOM.hasClass(n, 'mceItemHidden') || DOM.hasClass(n, 'mceItemRemoved'))
						return;

					// Handle prefix
					if (tinymce.isIE && n.scopeName !== 'HTML' && n.scopeName)
						na = n.scopeName + ':' + na;

					// Remove internal prefix
					na = na.replace(/mce\:/g, '');

					// Handle node name
					switch (na) {
						case 'b':
							na = 'strong';
							break;

						case 'i':
							na = 'em';
							break;

						case 'img':
							if (v = DOM.getAttrib(n, 'src'))
								ti += 'src: ' + v + ' ';

							break;

						case 'a':
							if (v = DOM.getAttrib(n, 'name')) {
								ti += 'name: ' + v + ' ';
								na += '#' + v;
							}

							if (v = DOM.getAttrib(n, 'href'))
								ti += 'href: ' + v + ' ';

							break;

						case 'font':
							if (v = DOM.getAttrib(n, 'face'))
								ti += 'font: ' + v + ' ';

							if (v = DOM.getAttrib(n, 'size'))
								ti += 'size: ' + v + ' ';

							if (v = DOM.getAttrib(n, 'color'))
								ti += 'color: ' + v + ' ';

							break;

						case 'span':
							if (v = DOM.getAttrib(n, 'style'))
								ti += 'style: ' + v + ' ';

							break;
					}

					if (v = DOM.getAttrib(n, 'id'))
						ti += 'id: ' + v + ' ';

					if (v = n.className) {
						v = v.replace(/\b\s*(webkit|mce|Apple-)\w+\s*\b/g, '');

						if (v) {
							ti += 'class: ' + v + ' ';

							if (ed.dom.isBlock(n) || na == 'img' || na == 'span')
								na += '.' + v;
						}
					}

					na = na.replace(/(html:)/g, '');
					na = {name : na, node : n, title : ti};
					t.onResolveName.dispatch(t, na);
					ti = na.title;
					na = na.name;

					//u = "javascript:tinymce.EditorManager.get('" + ed.id + "').theme._sel('" + (de++) + "');";
					pi = DOM.create('a', {'href' : "javascript:;", role: 'button', onmousedown : "return false;", title : ti, 'class' : 'mcePath_' + (de++)}, na);

					if (p.hasChildNodes()) {
						p.insertBefore(DOM.create('span', {'aria-hidden': 'true'}, '\u00a0\u00bb '), p.firstChild);
						p.insertBefore(pi, p.firstChild);
					} else
						p.appendChild(pi);
				}, ed.getBody());

				if (DOM.select('a', p).length > 0) {
					t.statusKeyboardNavigation = new tinymce.ui.KeyboardNavigation({
						root: ed.id + "_path_row",
						items: DOM.select('a', p),
						excludeFromTabOrder: true,
						onCancel: function() {
							ed.focus();
						}
					}, DOM);
				}
			}*/
		},

		_mceInsertAnchor: function(ui, v) {
			var ed = this.editor;

			ed.windowManager.open({
				url: this.url + '/anchor.htm',
				width: 320 + parseInt(ed.getLang('ws.anchor_delta_width', 0)),
				height: 96 + parseInt(ed.getLang('ws.anchor_delta_height', 0)),
				inline: true
			}, {
				theme_url: this.url
			});
		},

		_mceCharMap: function() {
			var ed = this.editor;

			ed.windowManager.open({
				url: this.url + '/charmap.htm',
				width: 550 + parseInt(ed.getLang('ws.charmap_delta_width', 0)),
				height: 281 + parseInt(ed.getLang('ws.charmap_delta_height', 0)),
				inline: true
			}, {
				theme_url: this.url
			});
		},

		_mceLink: function() {
			var ed = this.editor;

			ed.windowManager.open({
				url: this.url + '/link.htm',
				width: 310 + parseInt(ed.getLang('ws.link_delta_width', 0)),
				height: 183 + parseInt(ed.getLang('ws.link_delta_height', 0)),
				inline: true
			}, {
				theme_url: this.url
			});
		},

		_mceImage: function() {
			var ed = this.editor;

			// Internal image object like a flash placeholder
			if (ed.dom.getAttrib(ed.selection.getNode(), 'class', '').indexOf('mceItem') != -1)
				return;

			ed.windowManager.open({
				url: this.url + '/image.htm',
				width: 355 + parseInt(ed.getLang('ws.image_delta_width', 0)),
				height: 220 + parseInt(ed.getLang('ws.image_delta_height', 0)),
				inline: true
			}, {
				theme_url: this.url
			});
		},

		_mceMedia: function() {
		},

		_mceCodeEditor: function() {
			var ed = this.editor;

			ed.windowManager.open({
				url: this.url + '/code_editor.htm',
				width: parseInt(ed.getParam('theme_ws_code_editor_width', 620)),
				height: parseInt(ed.getParam('theme_ws_code_editor_height', 480)),
				inline: true,
				resizable: true,
				maximizable: true
			}, {
				theme_url: this.url
			});
		}

	});

	tinymce.ThemeManager.add('ws', tinymce.themes.wsTheme);
}(tinymce));
