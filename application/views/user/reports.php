<section class="section report">
<h1>Отчеты</h1>
<?php Widget::render('datepicker', array('css', 'js', 'selector' => '.datepicker')) ?>
<div class="filter">
    <form method="POST" accept-charset="UTF-8" action="">
        <div class="it-col">
            <label for="it-from"> c </label>
            <div class="it-t">
               <input class="it-text datepicker" type="text" name="from" id="it-from" value="<?php echo Arr::get($_REQUEST, 'from'); ?>" />
            </div>
        </div>
        <div class="it-col">
            <label for="it-to"> по </label>
            <div class="it-t">
               <input class="it-text datepicker" type="text" name="to" id="it-to" value="<?php echo Arr::get($_REQUEST, 'to'); ?>" />
            </div>
        </div>
        <div class="it-col last">
            <input type="hidden" name="token" value="<?php echo Security::token() ?>" />
            <button class="it-button" value="1" name="filter" type="submit">Отфильтровать</button>
        </div>
    </form>
</div>
<table class="table">
    <thead>
        <th>Дата</th>
        <th>Операция</th>
        <th>Сумма</th>
    </thead>
    <tbody>
       <?php foreach($reports as $report) : ?>
        <tr>
            <td><?php echo date('d.m.Y H:i:s', $report->created)  ?></td>
            <td><?php echo $report->type->title ?></td>
            <td><?php echo $report->ball ?></td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>
<?php echo $paging ?>
</section>