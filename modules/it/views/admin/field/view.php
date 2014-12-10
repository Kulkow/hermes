<div class="right">
	<a href="/admin/field/order<?php echo URL::query() ?>" class="ico ok text hidden" id="order-update">Сохранить порядок</a>
	<a href="/admin/field/add<?php echo URL::query() ?>" class="ico add text">Новое поле</a>
</div>
<h1>Управление полями формы <?php echo t($form->object_name().'.type') ?> &laquo;<span><?php echo $form->title ?></span>&raquo;</h1>
<table class="table" id="table-field">
	<thead>
    	<tr>
        	<th>Заголовок</th>
        	<th>Тип</th>
        	<th>Пояснение</th>
        	<th>Обязательное</th>
        	<th>Класс (CSS)</th>
        	<th>Управление</th>
    	</tr>
    </thead>
    <tbody id="order-list">
    	<?php foreach ($form->form_fields(TRUE) as $field) : ?>
    		<tr<?php if ($field->hide) echo ' class="hide"' ?> id="<?php echo $field->id ?>">
    			<td><b class="order-handle"></b><?php echo $field->title ?></td>
    			<td><?php echo t('field.type.'.$field->type) ?></td>
    			<td><?php echo $field->notice ?></td>
    			<td><?php echo t('field.required.'.$field->required) ?></td>
    			<td><?php echo $field->class ?></td>
    			<td class="actions">
					<a href="<?php echo $field->url_admin('edit') ?>" class="ico edit" title="Редактировать"></a>
					<a href="<?php echo $field->url_admin('toggle') ?>" class="ico hide" title="Видимость"></a>
					<a href="<?php echo $field->url_admin('delete') ?>" class="ico del" title="Удалить"></a>
    			</td>
    		</tr>
    	<?php endforeach ?>
	</tbody>
</table>
<script src="/media/libs/sortable/jquery-ui-1.8.18.custom.min.js"></script>
<script>
it.lang.toggle = ['Поле скрыто', 'Поле влючено'];
it.lang.deleteConfirm = 'Подтвердите удаление поля';
it.lang.deleteOk = 'Поле удалено';
it.lang.orderUpdate = 'Порядок полей сохранен';
</script>