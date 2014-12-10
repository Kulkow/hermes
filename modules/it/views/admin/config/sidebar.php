<nav id="nav">
	<ul>
		<li<?php if ($current == 'site') echo ' class="current"' ?>>
			<a href="/admin/config/site">Главная страница</a>
		</li>
		<!--<li<?php if ($current == 'skin') echo ' class="current"' ?>>
			<a href="/admin/config/skin">Шаблон сайта</a>
		</li>-->
		<li<?php if ($current == 'password') echo ' class="current"' ?>>
			<a href="/admin/config/password">Пароль администратора</a>
		</li>
	</ul>
</nav>