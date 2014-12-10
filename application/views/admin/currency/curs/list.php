<h1>Валюты</h1>
   <div class="right">
    	<a href="/admin/curs/curs_add" class="ico add text">Добавить курс</a>
    </div>
<?php if ($curses) : ?>
   <table class="table">
        <thead>
            <tr>
                <th style="width: 10%;">ID</th>
                <th>Курс</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        	<?php foreach ($curses as $curs) : ?>
        		<tr class="item">
                        <td><?php echo $curs->id; ?></td>
                        <td>
                               1 <?php echo $curs->currency->code; ?> = <?php echo $curs->value; ?> <?php echo $curs->currency_eq->code; ?> 
                        </td>
                        <td class="actions">
        					<a href="<?php echo $curs->url_admin('edit') ?>" class="ico edit" title="Редактировать"></a>
        					<a href="<?php echo $curs->url_admin('delete') ?>" class="ico del" title="Удалить"></a>
                        </td>	
        		</tr>
        	<?php endforeach ?>
        </tbody>
    </table>
	<?php echo $paging ?>
<?php endif ?>