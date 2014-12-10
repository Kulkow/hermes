<h1>Планируемые начисления</h1>
<?php if($plans): ?>
<table class="table">
    <thead>
        <th>Дата планируемого начисления</th>
        <th>Операция</th>
        <th>Баллов</th>
    </thead>
    <tbody>
       <?php foreach($plans as $plan) : ?>
        <tr>
            <td><?php echo date("d.m.Y H:i",$plan->accrual) ?></td>
            <td><?php echo $plan->operation() ?></td>
            <td><?php echo $plan->ball ?></td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>
<?php else : ?>
<p>Нет планируемых начислений</p>
<?php endif ?>
