<h1>Валюты</h1>
   <div class="right">
        <a href="/admin/curs/curs" class="ico add text">Курс валют</a>
    	<a href="/admin/curs/add" class="ico add text">Добавить валюту</a>
    </div>
<?php if ($currencys) : ?>
   <table class="table">
        <thead>
            <tr>
                <th style="width: 10%;">ID</th>
                <th>Code</th>
                <th>Описание</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        	<?php foreach ($currencys as $currency) : ?>
        		<tr class="item">
                        <td><?php echo $currency->id; ?></td>
                        <td><?php echo $currency->code; ?></td>
        		        <td><?php echo $currency->description; ?></td>
                        <td class="actions">
        					<a href="<?php echo $currency->url_admin('edit') ?>" class="ico edit" title="Редактировать"></a>
        					<a href="<?php echo $currency->url_admin('delete') ?>" class="ico del" title="Удалить"></a>
                        </td>	
        		</tr>
        	<?php endforeach ?>
        </tbody>
    </table>
	<?php echo $paging ?>
<?php endif ?>