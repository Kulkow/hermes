<h1>Пользователи</h1>
<div class="right">
    	
    </div>
<?php if ($bills) : ?>
   <div class="sort">
        <?php $sort_field = array() ?> 
        <?php foreach($sort_field as $field) : ?>
            <div class="field">
              <a href="<?php echo $field->url() ?>" title=""></a>  <?php echo $field['name'] ?>
            </div>
        <?php endforeach ?>
   </div>
   <table class="table">
        <thead>
            <tr>
                <th>номер</th>
                <th>Владелец</th>
                <th>Сумма</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        	<?php foreach ($bills as $bill) : ?>
        		<tr class="item">
        		        <td><?php echo $bill->id ?></td>
                        <td><?php echo $bill->card->user->fullname() ?></td>
                        <td><?php echo $bill->summa.' '.$bill->currency->render(); ?></td>
                        <td><?php echo $bill->type.': '.$bill->akkaunt.' '.$bill->phone; ?></td>
                        <td class="actions">
        					<a href="<?php echo $bill->url_admin('delete') ?>" class="ico del" title="Удалить"></a>
                        </td>	
        		</tr>
        	<?php endforeach ?>
        </tbody>
    </table>
	<?php echo $paging ?>
<?php endif ?>