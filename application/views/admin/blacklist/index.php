<h1>Черный - лист</h1>
   <div class="sort">
        <?php $sort_field = array() ?> 
        <?php foreach($sort_field as $field) : ?>
            <div class="field">
              <a href="<?php echo $field->url() ?>" title=""></a>  <?php echo $field['name'] ?>
            </div>
        <?php endforeach ?>
   </div>
   <div class="right">
    	<a href="/admin/blacklist/add" class="ico add text">Добавить в черный лист</a>
    </div>
<?php if ($blacklist) : ?>
   <table class="table">
        <thead>
            <tr>
                <th>IP</th>
                <th>Активность</th>
                <th>Дата добавления/изменения</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        	<?php foreach ($blacklist as $black) : ?>
        		<tr class="item">
        		        <td><?php echo $black->ip ?></td>
                        <td><?php echo $black->active ?></td>
                        <td><?php echo date("d.m.Y H:i:s", $black->created) ?></td>
                        <td class="actions">
        					<a href="<?php echo $black->url_admin('edit') ?>" class="ico edit" title="Редактировать"></a>
        					<a href="<?php echo $black->url_admin('delete') ?>" class="ico del" title="Удалить"></a>
                        </td>	
        		</tr>
        	<?php endforeach ?>
        </tbody>
    </table>
	<?php echo $paging ?>
<?php endif ?>