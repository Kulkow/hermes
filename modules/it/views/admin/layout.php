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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
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
						<a href="/admin/card">Карты</a>
					</li>
					<li<?php if ($menu == 'config') echo ' class="current"' ?>>
						<a href="/admin/config">Настройки</a>
					</li>
                    <li<?php if ($menu == 'user') echo ' class="current"' ?>>
						<a href="/admin/user">Пользователи</a>
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