<nav class="nav user">
    <ul>
        <li><a class="add" href="<? echo Site::url('money/up') ?>" title="Пополнить">Пополнить</a></li>
        <li><a class="add" href="<? echo Site::url('money/out') ?>" title="Вывести">Вывести</a></li>
    </ul>
</nav>
<h1>Баланс</h1>
<?php if($auth_user->active_time > time()): ?>
<!--<p>Ожидайте активации бонусной карты:<?php echo date('d.m.Y', $auth_user->active_time) ?></p>-->
<?php endif ?>
<?php if($balance) : ?>
    <p><b>Текущий баланс:</b><?php echo $balance  ?> баллов</p>
<?php else : ?>
<p> <a href="<? echo Site::url('money/up')?>"> Пополните баланс</a></p>
<?php endif ?>
<?php if($referals): ?>
<table class="table">
    <thead>
        <th>Дата</th>
        <th>Баллов</th>
        <th>%</th>
    </thead>
    <tbody>
       <?php foreach($referals as $referal) : ?>
        <tr>
            <td><?php echo date("d.m.Y H:i",$referal->created) ?></td>
            <td><?php echo $referal->ball ?></td>
            <td><?php echo $referal->percent ?></td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>
<?php else : ?>
<!--<p>Нет планируемых начислений</p>-->
<?php endif ?>