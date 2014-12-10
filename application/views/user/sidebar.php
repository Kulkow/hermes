<nav class="nav user">
    <ul>
        <!--<li <?php echo ($menu_user == 'subscription' ? 'class="active"' : '')?>><a href="<?php echo $user->url('subscription') ?>" title="Уведомления">Уведомления</a></li>-->
        <li <?php echo ($menu_user == 'new_password' ? 'class="active"' : '')?>><a href="<?php echo $user->url('new_password') ?>" title="">Сменить пароль</a></li>
        <li <?php echo ($menu_user == 'profile' ? 'class="active"' : '')?>><a href="<?php echo $user->url('profile') ?>" title="Редактировать профиль">Редактировать профиль</a></li>
    </ul>
</nav>