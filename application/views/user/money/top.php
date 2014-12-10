<? if(FALSE): ?>
<nav class="nav user">
    <ul>
        <li <?php echo ($menu_user == 'up' ? 'class="active"' : '')?>><a class="add" href="<? echo Site::url('money/up') ?>" title="Пополнить">Пополнить</a></li>
        <li <?php echo ($menu_user == 'out' ? 'class="active"' : '')?>><a class="add" href="<? echo Site::url('money/out') ?>" title="Вывести">Вывести</a></li>
    </ul>
</nav>
<? endif ?>
<nav class="nav user">
    <ul>
        <li <?php echo ($pay_type == 'qiwi' ? 'class="active"' : '')?>><a class="add" href="<? echo Site::url('money/'.$menu_user.'/qiwi') ?>" title="qiwi">Qiwi</a></li>
        <li <?php echo ($pay_type == 'perfect' ? 'class="active"' : '')?>><a class="add" href="<? echo Site::url('money/'.$menu_user.'/perfect') ?>" title="Perfect Money">Perfect Money</a></li>
    </ul>
</nav>
