<?php defined('SYSPATH') OR die('No direct access allowed.');

$domain = rtrim(Url::base(TRUE), '/');

return array(
	'guest' => array(
		// Разрешённые теги
		'cfgAllowTags' => array(
			array(
				array('i', 'b', 'em',  'strong', 'del', 'ins', 'li', 'ol', 'ul', 'sup', 'abbr', 'sub', 'br', 'hr', 'p', 'blockquote', 'q'),
			),
		),
		// Коротие теги типа
		'cfgSetTagShort' => array(
			array(
				array('br', 'hr')
			),
		),
		// Разрешённые параметры тегов
		'cfgAllowTagParams' => array(
			array(
				'abbr',
				array('title')
			),
		),
		// Параметры тегов являющиеся обязательными
		'cfgSetTagParamsRequired' => array(
			array(
				'img',
				'src'
			),
		),
		// Теги которые необходимо вырезать из текста вместе с контентом
		'cfgSetTagCutWithContent' => array(
			array(
				array('script',  'style')
			),
		),
		// Вложенные теги
		'cfgSetTagChilds' => array(
			array(
				'ul',
				array('li'),
				false,
				true
			),
			array(
				'ol',
				array('li'),
				false,
				true
			),
		),
		'cfgSetAutoBrMode' => array(
			array(FALSE)
		),
		// Не нужна авто-расстановка <br>
		'cfgSetTagNoAutoBr' => array(
			array(
				array('ul', 'ol')
			)
		),
		// Автозамена
		'cfgSetAutoReplace' => array(
			array(
				array('+/-', '(c)', '(с)', '(r)', '(C)', '(С)', '(R)'),
				array('±', '©', '©', '®', '©', '©', '®')
			)
		),
		// Теги, после которых необходимо пропускать одну пробельную строку
		'cfgSetTagBlockType' => array(
			array(
				array('ol', 'ul', 'blockquote', 'q')
			)
		),
	),

	'user' => array(
		// Разрешённые теги
		'cfgAllowTags' => array(
			array(
				array('a', 'img', 'i', 'b', 'em',  'strong', 'del', 'ins', 'li', 'ol', 'ul', 'sup', 'abbr', 'sub', 'h4', 'h5', 'h6', 'br', 'hr', 'q', 'blockquote', 'iframe', 'p'),
			),
		),
		// Коротие теги типа
		'cfgSetTagShort' => array(
			array(
				array('br', 'img', 'hr')
			),
		),
		// Разрешённые параметры тегов
		'cfgAllowTagParams' => array(
			array(
				'img',
				array('src' => array('#domain' => $domain), 'alt' => '#text', 'title', 'class' => array('r-align', 'l-align'), 'width' => '#int', 'height' => '#int')
			),
			array(
				'a',
				array('title', 'href', 'rel' => '#text', 'target' => array('_blank'))
			),
			array(
				'abbr',
				array('title')
			),
			array(
				'iframe',
				array('width' => '#int', 'height' => '#int', 'src' => array('#domain'=>array('youtube.com','rutube.ru','vimeo.com','vk.com')))
			),
		),
		// Параметры тегов являющиеся обязательными
		'cfgSetTagParamsRequired' => array(
			array(
				'img',
				'src'
			),
		),
		// Теги которые необходимо вырезать из текста вместе с контентом
		'cfgSetTagCutWithContent' => array(
			array(
				array('script',  'style')
			),
		),
		// Вложенные теги
		'cfgSetTagChilds' => array(
			array(
				'ul',
				array('li'),
				false,
				true
			),
			array(
				'ol',
				array('li'),
				false,
				true
			),
		),
		// Если нужно оставлять пустые не короткие теги
		'cfgSetTagIsEmpty' => array(
			array(
				array('a', 'iframe')
			),
		),
		'cfgSetAutoBrMode' => array(
			array(FALSE)
		),
		// Не нужна авто-расстановка <br>
		'cfgSetTagNoAutoBr' => array(
			array(
				array('ul', 'ol')
			)
		),
		// Автозамена
		'cfgSetAutoReplace' => array(
			array(
				array('+/-', '(c)', '(с)', '(r)', '(C)', '(С)', '(R)'),
				array('±', '©', '©', '®', '©', '©', '®')
			)
		),
		// Теги, после которых необходимо пропускать одну пробельную строку
		'cfgSetTagBlockType' => array(
			array(
				array('h4', 'h5', 'h6', 'ol', 'ul', 'blockquote', 'q')
			)
		),
	),

    'admin' => array(
		// Разрешённые теги
		'cfgAllowTags' => array(
			array(
				array('a', 'img', 'i', 'b', 'em',  'strong', 'del', 'ins', 'li', 'ol', 'ul', 'sup', 'abbr', 'sub', 'h4', 'h5', 'h6', 'br', 'hr', 'q', 'blockquote', 'iframe', 'p', 'table','th','tr','td', 'script', 'style', 'pre'),
			),
		),
		// Коротие теги типа
		'cfgSetTagShort' => array(
			array(
				array('br','img', 'hr')
			),
		),
		// Преформатированные теги
		'cfgSetTagPreformatted' => array(
			array(
				array('pre')
			),
		),
		// Разрешённые параметры тегов
		'cfgAllowTagParams' => array(
			array(
				'img',
				array('src', 'alt' => '#text', 'title', 'width' => '#int', 'height' => '#int', 'class'=> array('r-align', 'l-align'))
			),
			array(
				'a',
				array('title', 'href', 'rel' => '#text', 'target' => array('_blank'))
			),
			array(
				'abbr',
				array('title')
			),
			array(
				'iframe',
				array('width' => '#int', 'height' => '#int', 'src' => array('#domain'=>array('youtube.com','rutube.ru','vimeo.com','vk.com')))
			),
			array(
				'td',
				array('colspan'=>'#int','rowspan'=>'#int', 'height'=>'#int', 'width'=>'#int', 'class' => '#text')
			),
			array(
				'table',
				array('height'=>'#int','width'=>'#int','class'=>'#text')
			),
		),
		// Параметры тегов являющиеся обязательными
		'cfgSetTagParamsRequired' => array(
			array(
				'img',
				'src'
			),
		),
		// Вложенные теги
		'cfgSetTagChilds' => array(
			array(
				'ul',
				array('li'),
				false,
				true
			),
			array(
				'ol',
				array('li'),
				false,
				true
			),
			array(
				'table',
				array('tr'),
				false,
				true
			),
			array(
				'tr',
				array('td','th'),
				false,
				true
			),
		),
		// Если нужно оставлять пустые не короткие теги
		'cfgSetTagIsEmpty' => array(
			array(
				array('a','iframe')
			),
		),
		'cfgSetAutoBrMode' => array(
			array(FALSE)
		),
		// Не нужна авто-расстановка <br>
		'cfgSetTagNoAutoBr' => array(
			array(
				array('ul','ol','table','tr')
			)
		),
		// Автозамена
		'cfgSetAutoReplace' => array(
			array(
				array('+/-', '(c)', '(с)', '(r)', '(C)', '(С)', '(R)'),
				array('±', '©', '©', '®', '©', '©', '®')
			)
		),
		'cfgSetTagNoTypography' => array(
			array(
				array('pre')
			),
		),
		// Теги, после которых необходимо пропускать одну пробельную строку
		'cfgSetTagBlockType' => array(
			array(
				array('h4','h5','h6','ol','ul','blockquote','q','pre')
			)
		),
	),
	// настройки для обработки текста в результатах поиска
	'search' => array(
		// Разрешённые теги
		'cfgAllowTags' => array(
			// вызов метода с параметрами
			array(
				array('span'),
			),
		),
		// Разрешённые параметры тегов
		'cfgAllowTagParams' => array(
			array(
				'span',
				array('class' => '#text')
			),
		),
	),
);