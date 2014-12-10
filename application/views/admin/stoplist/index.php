<h1>Стоп - лист</h1>
   <div class="sort">
        <?php $sort_field = array() ?> 
        <?php foreach($sort_field as $field) : ?>
            <div class="field">
              <a href="<?php echo $field->url() ?>" title=""></a>  <?php echo $field['name'] ?>
            </div>
        <?php endforeach ?>
   </div>
   <div class="right">
    	<a href="/admin/stoplist/add" class="ico add text">Добавить в стоп-лист</a>
    </div>
<?php if ($stoplist) : ?>
   <table class="table">
        <thead>
            <tr>
                <th>IP</th>
                <th>Бонусная карта или логин</th>
                <th>Дата окончания действия</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        	<?php foreach ($stoplist as $stop) : ?>
        		<tr class="item">
        		        <td><?php echo $stop->ip ?></td>
                        <td><?php echo $stop->card ?></td>
                        <td><?php echo date("d.m.Y H:i:s", $stop->expires) ?></td>
                        <td class="actions">
        					<a href="<?php echo $stop->url_admin('edit') ?>" class="ico edit" title="Редактировать"></a>
        					<a href="<?php echo $stop->url_admin('delete') ?>" class="ico del" title="Удалить"></a>
                        </td>	
        		</tr>
        	<?php endforeach ?>
        </tbody>
    </table>
	<?php echo $paging ?>
<?php endif ?>