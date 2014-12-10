<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8" />
	<title>Администрирование - <?php echo $site->name ?></title>
	<!--[if lte IE 8]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<link rel="stylesheet" href="/media/libs/it/css/it.reset.css" />
	<link rel="stylesheet" href="/media/libs/it/css/it.forms.css" />
	<link rel="stylesheet" href="/media/admin/css/style.css" />
	<link rel="stylesheet" href="/media/libs/notifier/jquery.notifier.css" />
	<link rel="stylesheet" href="/media/libs/jqueryui/jquery-ui-1.8.18.custom.css" />
	<script type="text/javascript" src="<?php echo URL::site('/media/js/jquery-2.0.3.min.js')?> "></script>
	<script type="text/javascript" src="<?php echo URL::site('/media/jqueryui/js/jquery-ui-1.9.2.custom.min.js')?> "></script>
	<script src="/media/libs/it/js/it.core.js"></script>
	<script src="/media/libs/notifier/jquery.notifier.js"></script>
	<script src="/media/admin/js/common.js"></script>
</head>
<body>
	<div id="container">
		<header id="header">
			<a href="/admin" id="logo"><p>Администрирование</p><?php echo $site->name ?></a>
			<div class="bar">
				<?php if (Auth::instance()->logged_in()) : ?>
					<a href="/admin/logout" class="logout" title="Выход"></a>
				<?php endif ?>
				<a href="/" class="home" title="На сайт" target="_blank"></a>
			</div>
		</header>
		<nav id="menu">
			<?php if (Auth::instance()->logged_in()) : ?>
				<ul>
					<li<?php if ($menu == 'page') echo ' class="current"' ?>>
						<a href="/admin/page">Страницы</a>
					</li>
                    <li<?php if ($menu == 'menu') echo ' class="current"' ?>>
						<a href="/admin/menu">Меню</a>
					</li>
					<li<?php if ($menu == 'card') echo ' class="current"' ?>>
						<a href="/admin/card">Счета-Пользователи</a>
					</li>
					<li<?php if ($menu == 'users') echo ' class="current"' ?>>
						<a href="/admin/users">Пользователи</a>
					</li>
                    <? if(FALSE): ?>
                    <li<?php if ($menu == 'banner') echo ' class="current"' ?>>
						<a href="/admin/banner">Баннеры</a>
					</li>
                    <? endif ?>
                    <li<?php if ($menu == 'slider') echo ' class="current"' ?>>
						<a href="/admin/slider">Слайдер</a>
					</li>
                    <li<?php if ($menu == 'news') echo ' class="current"' ?>>
						<a href="/admin/news">Новости</a>
					</li>
                    <li<?php if ($menu == 'payment') echo ' class="current"' ?>>
						<a href="/admin/payment">Платежные системы</a>
					</li>
                    <li<?php if ($menu == 'bill') echo ' class="current"' ?>>
						<a href="/admin/bill">Очередь на вывод</a>
					</li>
                    <li<?php if ($menu == 'tarif') echo ' class="current"' ?>>
						<a href="/admin/tarif">Тарифы</a>
					</li>
                    <li<?php if ($menu == 'curs') echo ' class="current"' ?>>
						<a href="/admin/curs">Валюты</a>
					</li>
                    <? if(FALSE): ?>
                    <li<?php if ($menu == 'stoplist') echo ' class="current"' ?>>
						<a href="/admin/stoplist">Стоп-лист</a>
					</li>
                    <li<?php if ($menu == 'blacklist') echo ' class="current"' ?>>
						<a href="/admin/blacklist">Черный список</a>
					</li>
                    <? endif ?>
                    <li<?php if ($menu == 'type') echo ' class="current"' ?>>
						<a href="/admin/event/type">Типы событий</a>
					</li>
                    <li<?php if ($menu == 'config') echo ' class="current"' ?>>
						<a href="/admin/config">Настройки</a>
					</li>
                    <li<?php if ($menu == 'logs') echo ' class="current"' ?>>
						<a href="/admin/logs">Логи</a>
					</li>
                    
				</ul>
			<?php endif ?>
		</nav>
		<div id="wrapper"<?php if (isset($sidebar)) echo ' class="aside"' ?>>
			<div id="page">
				<div id="content">
					<?php echo $content ?>
				</div>
			</div>
			<?php if (isset($sidebar)) : ?>
				<aside id="sidebar">
					<?php echo $sidebar ?>
				</aside>
			<?php endif ?>
		</div>
	</div>
	<footer id="footer">
        <ul>
        	<li class="first">Все права защищены</li>
        	<li>&copy; 2008-<?php echo date('Y') ?></li>
        	<li>&laquo;<a href="http://ip-design.ru">Интернет Проекты</a>&raquo;</li>
        </ul>
	</footer>
</body>
</html>