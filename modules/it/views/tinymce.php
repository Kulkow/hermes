<?php

if ( ! isset($selector))
{
	$selector = 'tinymce';
}

$theme = 'modern';
$skin = 'lightgray';
$lang = 'ru';
//$plugins = 'spellchecker,emotions,iespell,inlinepopups,fullscreen,tabfocus,paste';
$plugins = 'spellchecker,emoticons,image,table,fullscreen,tabfocus,paste,code,filemanager,media,link';
/*$plugins = array("advlist autolink link image lists charmap print preview hr anchor pagebreak",
         "searchreplace wordcount visualblocks visualchars code insertdatetime media nonbreaking",
         "table contextmenu directionality emoticons paste textcolor filemanager");*/
$gz_init = array(
	'themes'	=> $theme,
	'languages'	=> $lang,
);
$init = array(
	'mode'				=> 'specific_textareas',
	'editor_selector'	=> $selector,
	'theme'				=> $theme,
	'skin'				=> $skin,
	'convert_urls'		=> 0,
    'image_advtab'     => true,
   	'language'			=> $lang,
	'formats'			=> array(
		'bold'			=> array('inline' => 'strong'),
		'italic'		=> array('inline' => 'em'),
		'underline'		=> array('inline' => 'ins'),
		'strikethrough'	=> array('inline' => 'del'),
	),
	'theme_styles'		=> 'lightbox=lightbox;clear=clear;Документ Word=doc;Документ Excel=doc xls;Презентация=doc ppt',
	'inlinepopups_skin'	=> $theme.'-'.$skin,
	'theme_toolbar1'	=> 'bold,italic,underline,strikethrough,|,bullist,numlist,blockquote,|,link,unlink,anchor,image,media,hr,|,sup,sub,|,emotions,charmap',
	'spellchecker_languages' => '+\u0420\u0443\u0441\u0441\u043a\u0438\u0439=ru,\u0423\u043a\u0440\u0430\u0457\u043d\u0441\u044c\u043a\u0438\u0439=uk,English=en',
	'spellchecker_word_separator_chars' => '\\s!"#$%&()*+,./:;<=>?@[\]^_{|}\xa7 \xa9\xab\xae\xb1\xb6\xb7\xb8\xbb\xbc\xbd\xbe\u00bf\xd7\xf7\xa4\u201d\u201c',
	'file_browser_callback'	=> 'file_browser',
	'paste_text_sticky' => 1,
	'paste_text_sticky_default' => 1,
);

if ( ! isset($cut))
{
	$plugins .= ',pagebreak';
	$init['theme_toolbar1'] = 'bold,italic,underline,strikethrough,|,formatblock,|,bullist,numlist,blockquote,|,link,unlink,anchor,image,media,hr,|,sup,sub,|,emotions,charmap,|,clean,|,pagebreak';
	$init['pagebreak_separator'] = '<!--break-->';
}

$init['plugins'] = $plugins;

?>
<script>
tinyMCE.init(<?php echo json_encode($init) ?>);
</script>