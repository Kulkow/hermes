(function($) {
	$.fn.wsUpload = function(options) {

		options = $.extend({
			path: '/media/FileAPI/',
			data: {}
		}, options);
        
        function in_array(what, where) {
            for(var i=0; i<where.length; i++)
                if(what == where[i])
                    return true;
            return false;
        }

		var input = $(this.get(0)), queue = [], index = last = 0, active = false;

		var fu = {
			add: function(files) {
				$.each(files, function(index, file) {
					/* check errors */

					var data = {file: file, uid: FileAPI.uid(file)};
					if (/image/.test(file.type) && options.preview){
                        
			        	FileAPI.Image(file)
							.preview(options.preview.width, options.preview.height)
							.rotate('auto')
							.get(function (err, image) {
								if( !err ) {
									var preview = $('<div class="preview" id="preview-' + data.uid + '"/>');
									preview.appendTo(options.preview.container).get(0).appendChild(image);
									$('<a href="javascript:;" class="cancel">Отменить загрузку</a>').click(function() {
										fu.abort(data);
									}).appendTo(preview);
                                    
                                    /**check*/
                                    var valid = options.valid;
                                    var check = true;
                                    if(valid)
                                    {
                                        if(/^image/.test(file.type))
                                        {
                                            if(valid.maxsize)
                                            {
                                                if(file.size > valid.maxsize * FileAPI.MB)
                                                {
                                                    check = false;
                                                    fu.error(data, 'Превышен размер изображения более ' + valid.maxsize + 'MB'); 
                                                }            
                                            }
                                            if(valid.type)
                                            {
                                                var types = valid.type.split(',');
                                                var type = file.type.replace(/image\//g, '');
                                                if(! in_array(type, types))
                                                {
                                                    check = false;
                                                    fu.error(data, 'Не верный формат изображения '+ type + '. Должен быть ' + valid.type ); 
                                                }            
                                            }
                                         }
                                    } 
                                    if(check)
                                    {
                                        queue[last++] = data;
            					        setTimeout(fu.start, 10);                            
                                    } 
								}
							});
                       }
                       else
                       {
                          /**
                          * if Image Error OR upload file
                          */
                          var preview = $('<div class="preview" id="preview-' + data.uid + '"/>');
						  preview.appendTo(options.preview.container).get(0);
                          fu.error(data, 'Файл' + data.file.name + ' не является картинкой');
                          setTimeout(function(){
                           preview.fadeOut(function() {
            					preview.remove();
            				}); 
                          }, 1000);
                       }      
 
				});
			},
			start: function() {
				if (!active && index < last) {
					var data = queue[index++];
					if (data && !data.error) {
						active = true;
                                                
						fu.upload(data);
					}
				}
			},
			upload: function(data) {
                
				var preview = $('#preview-' + data.uid);
				var progress = $('<div class="progress"/>').appendTo(preview);
				var bar = $('<div class="bar"/>').appendTo(progress);
                
               
				var files = {};
				files[input.prop('name')] = data.file;
                
				data.file.xhr = FileAPI.upload({
					url: options.url,
					files: files,
                   
					data: options.data,
					upload: function() {
						preview.addClass('upload');
						progress.show();
					},
					progress: function(e) {
						bar.css('width', e.loaded/e.total*100+'%');
					},
					complete: function (error, xhr) {
						progress.fadeOut(function() {
							progress.hide();
						});
						preview.removeClass('upload');
						if (error) preview.addClass('error');
						options.complete && options.complete(error, xhr, data);
						active = false;
						fu.start();
					}
				});

                
			},
			abort: function(data) {
				if (data.file.xhr) data.file.xhr.abort();
                
				var preview = $('#preview-' + data.uid).fadeOut(function() {
					preview.remove();
				});
			},
            error:function(data, error)
            {
                var preview = $('#preview-' + data.uid);
                preview.append('<p class="error">error: ' + error + '</p>').addClass('error');
            }
		}

		FileAPI = {
			staticPath: options.path
		};
        
        
		$.ajax({
			url: options.path + 'FileAPI.min.js',
			dataType: 'script',
		    cache: true
		}).done(function(script, textStatus) {
			if (textStatus == 'success') {

				if(FileAPI.support.dnd) {
					$('#drag-n-drop').show();
					$(document).dnd(function (over) {
						$('#drop-zone').toggle(over);
					}, function (files) {
						fu.add(files);
					});
				}

				FileAPI.event.on(input.get(0), 'change', function(e) {
					var files = FileAPI.getFiles(e);
                   
                    
					fu.add(files);
					FileAPI.reset(e.currentTarget);
				});
			}
		});

		return input;
	}
})(jQuery);
