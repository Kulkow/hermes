<h1>Типы событий</h1>
<div class="right">
    	<!--<a href="/admin/user/order" class="ico ok text hidden" id="order-update">Сохранить</a>-->
    	<a href="/admin/event/type/add" class="ico add text">Добавить тип события</a>
    </div>
<?php if ($event_types) : ?>
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
                <th>ID</th>
                <th>code</th>
                <th>Заголовок для сайта</th>
                <th>Описание(операции)</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        	<?php foreach ($event_types as $type) : ?>
        		<tr class="item">
        		        <td><?php echo $type->id ?></td>
                        <td><?php echo $type->code ?></td>
                        <td><?php echo $type->title ?></td>
                        <td><?php echo $type->description ?></td>
                        <td class="actions">
        					<a href="<?php echo $type->url_admin('edit') ?>" class="ico edit" title="Редактировать"></a>
        					<a href="<?php echo $type->url_admin('delete') ?>" class="ico del" title="Удалить"></a>
                        </td>	
        		</tr>
        	<?php endforeach ?>
        </tbody>
    </table>
	<?php echo $paging ?>
<?php endif ?>