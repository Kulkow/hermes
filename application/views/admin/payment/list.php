<h1>Способы оплаты</h1>
   <div class="right">
    	<a href="/admin/payment/add" class="ico add text">Добавить способ оплаты</a>
    </div>
<?php if ($payments) : ?>
   <table class="table">
        <thead>
            <tr>
                <th style="width: 10%;">code</th>
                <th>Название</th>
                <th>Логин/пароль</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        	<?php foreach ($payments as $payment) : ?>
        		<tr class="item">
                        <td><?php echo $payment->alias; ?></td>
        		        <td><?php echo $payment->title ?></td>
                        <td><?php echo $payment->login.':'.$payment->password; ?></td>
                        <td class="actions">
        					<a href="<?php echo $payment->url_admin('edit') ?>" class="ico edit" title="Редактировать"></a>
        					<a href="<?php echo $payment->url_admin('delete') ?>" class="ico del" title="Удалить"></a>
                        </td>	
        		</tr>
        	<?php endforeach ?>
        </tbody>
    </table>
	<?php echo $paging ?>
<?php endif ?>