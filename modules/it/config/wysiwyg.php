<?php defined('SYSPATH') OR die('No direct access allowed.');

return array(
            'ckeditor' => array(
                         'params' => array(
                                        'topic' => array(
                                              'uiColor' => '#050204',
                                              'toolbar_Full' => array(
                                              array('name' => 'document',
                                                    'items' => array ('Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates')),
                                              array('name' => 'editing',
                                                    'items' => array('Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt')),
                                              array('name' => 'forms',
                                                    'items' => array('Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField')),
                                              array('name' => 'paragraph',
                                                    'items' => array('NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl')),
                                              array('name' => 'links',
                                                    'items' => array('Link','Unlink','Anchor')),
                                              array('name' => 'insert',
                                                    'items' => array('Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak')),
                                              array('name' => 'styles',
                                                    'items' => array('Styles','Format','Font','FontSize')),
                                              array('name' => 'colors',
                                                    'items' => array('TextColor','BGColor')),
                                              array('name' => 'tools',
                                                    'items' => array('Maximize', 'ShowBlocks','-','About')),
                                              array('name' => 'clipboard',
                                                    'items' => array('Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo') ),
                                              array('name' => 'basicstyles',
                                              'items' => array('Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' )),
                                              )
                                              ),
                                        'comment' => array(
                                              'uiColor' => '#AADC6E',
                                              'width' => 450,
                                              'height' => 100,
                                              'toolbar_Full' => array(
                                              /*array('name' => 'document',
                                                    'items' => array ('Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates')),
                                              array('name' => 'editing',
                                                    'items' => array('Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt')),
                                              array('name' => 'forms',
                                                    'items' => array('Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField')),
                                              array('name' => 'paragraph',
                                                    'items' => array('NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl')),
                                              array('name' => 'links',
                                                    'items' => array('Link','Unlink','Anchor')),*/
                                             /* array('name' => 'insert',
                                                    'items' => array('Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak')),
                                              array('name' => 'styles',
                                                    'items' => array('Styles','Format','Font','FontSize')),*/
                                              array('name' => 'colors',
                                                    'items' => array('TextColor','BGColor')),
                                            /*  array('name' => 'tools',
                                                    'items' => array('Maximize', 'ShowBlocks','-','About')),
                                              array('name' => 'clipboard',
                                                    'items' => array('Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo') ),
                                             */ array('name' => 'basicstyles',
                                              'items' => array('Bold','Italic','Underline' )),
                                              )
                                              ),
                                        'edit' => array(
                                              'uiColor' => '#3D3D3D',
                                              'toolbar_Full' => array(
                                              /*array('name' => 'document',
                                                    'items' => array ('Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates')),
                                              array('name' => 'editing',
                                                    'items' => array('Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt')),
                                              array('name' => 'forms',
                                                    'items' => array('Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField')),
                                              array('name' => 'paragraph',
                                                    'items' => array('NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl')),
                                              array('name' => 'links',
                                                    'items' => array('Link','Unlink','Anchor')),*/
                                             /* array('name' => 'insert',
                                                    'items' => array('Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak')),
                                              */
                                              array('name' => 'basicstyles',
                                              'items' => array('Bold','Italic','Underline' )),
                                              array('name' => 'styles',
                                                    'items' => array('Styles','Format','Font','FontSize')),
                                              array('name' => 'insert',
                                                    'items' => array('Image')),
                                             /* array('name' => 'colors',
                                                    'items' => array('TextColor','BGColor')),
                                              array('name' => 'tools',
                                                    'items' => array('Maximize', 'ShowBlocks','-','About')),
                                              array('name' => 'clipboard',
                                                    'items' => array('Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo') ),
                                             */
                                              )
                                              ),
                                        'admin' => array(
                                                          'uiColor' => '#AADC6E',
                                                          'toolbar_Full' => array(
                                                          array('name' => 'document',
                                                                'items' => array ('Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates')),
                                                          array('name' => 'editing',
                                                                'items' => array('Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt')),
                                                          array('name' => 'forms',
                                                                'items' => array('Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField')),
                                                          array('name' => 'paragraph',
                                                                'items' => array('NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl')),
                                                          array('name' => 'links',
                                                                'items' => array('Link','Unlink','Anchor')),
                                                          array('name' => 'insert',
                                                                'items' => array('Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak')),
                                                          array('name' => 'styles',
                                                                'items' => array('Styles','Format','Font','FontSize')),
                                                          array('name' => 'colors',
                                                                'items' => array('TextColor','BGColor')),
                                                          array('name' => 'tools',
                                                                'items' => array('Maximize', 'ShowBlocks','-','About')),
                                                          array('name' => 'clipboard',
                                                                'items' => array('Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo') ),
                                                          array('name' => 'basicstyles',
                                                          'items' => array('Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' )),
                                                          )   ),
                                        'full' => array(
                                                      'uiColor' => '#AADC6E',
                                                      'toolbar_Full' => array(
                                                      array('name' => 'document',
                                                            'items' => array ('Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates')),
                                                      array('name' => 'editing',
                                                            'items' => array('Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt')),
                                                      array('name' => 'forms',
                                                            'items' => array('Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField')),
                                                      array('name' => 'paragraph',
                                                            'items' => array('NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl')),
                                                      array('name' => 'links',
                                                            'items' => array('Link','Unlink','Anchor')),
                                                      array('name' => 'insert',
                                                            'items' => array('Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak')),
                                                      array('name' => 'styles',
                                                            'items' => array('Styles','Format','Font','FontSize')),
                                                      array('name' => 'colors',
                                                            'items' => array('TextColor','BGColor')),
                                                      array('name' => 'tools',
                                                            'items' => array('Maximize', 'ShowBlocks','-','About')),
                                                      array('name' => 'clipboard',
                                                            'items' => array('Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo') ),
                                                      array('name' => 'basicstyles',
                                                      'items' => array('Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' )),
                                                      )),
                                        ),
                          'path' =>'/media/libs/ckeditor',
            ),
          'tinymce' => array(
                            'params' => array(
                                               'default' => array(
                                                       'theme' => 'advanced',
                                                       'mode' => 'specific_textareas',
                                                       'skin' => 'teenterra',
                                                       'language' => 'ru',
                                                       'convert_urls' => false,
                                                       'extended_valid_elements' => 'img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name]',
														'pagebreak_separator' => '<!--break-->',
														'formats' => array(
															'bold' => array('inline' => 'strong'),
															'italic' => array('inline' => 'em'),
															'underline' => array('inline' => 'ins'),
															'strikethrough' => array('inline' => 'del'),
														),
														'spellchecker_languages' => '+\u0420\u0443\u0441\u0441\u043a\u0438\u0439=ru,\u0423\u043a\u0440\u0430\u0457\u043d\u0441\u044c\u043a\u0438\u0439=uk,English=en',
														'spellchecker_word_separator_chars' => '\\s!"#$%&()*+,./:;<=>?@[\]^_{|}\xa7 \xa9\xab\xae\xb1\xb6\xb7\xb8\xbb\xbc\xbd\xbe\u00bf\xd7\xf7\xa4\u201d\u201c',
														),
                                               'user' => array(
                                                     'cut' => array(
                                                            'theme_advanced_buttons1' => 'bold, italic, underline, strikethrough',
                                                            'plugins' => 'pagebreak, style, layer, table',
                                                            ),
                                                      'full' => array(
                                                            'theme_advanced_blockformats' => 'p,h4,h5,h6',
                                                            'theme_advanced_buttons1' => 'bold, italic, underline, strikethrough,|undo,link, unlink, itfileman,bullist,numlist,sub,sup,abbr,pagebreak,formatselect,blockquote',
                                                            'plugins' => 'itfileman,pagebreak, advlink, iespell, inlinepopups, preview, media, searchreplace, contextmenu, paste, directionality,, nonbreaking, , wordcount, advlist',
                                                            ),
                                                        ),
                                               'admin' => array(
                                                     'cut' => array(
                                                            'theme_advanced_buttons1' => 'bold, italic, underline, strikethrough',
                                                            'plugins' => 'pagebreak, style, layer, table',
                                                            ),
                                                       'full' => array(
                                                        'theme_advanced_blockformats' => 'p,h4,h5,h6,div',
                                                        'theme_advanced_buttons1' => 'bold, italic, underline, strikethrough,|undo,link, unlink, itfileman,code,bullist,numlist,sub,sup,abbr,pagebreak,code,formatselect,blockquote',
                                                        'plugins' => 'itfileman,pagebreak, style, layer, table, save, advhr, advimage, advlink, emotions, iespell, inlinepopups, insertdatetime, preview, media, searchreplace, print, contextmenu, paste, directionality, fullscreen, noneditable, visualchars, nonbreaking, xhtmlxtras, template, wordcount, advlist, autosave',
                                                        ),
                                                        ),

                            ),
                            'path'  => '/media/libs/tinymce/jscripts/tiny_mce'

          )
);


