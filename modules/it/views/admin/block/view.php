<div class="right">
	<a href="/admin/block/order" class="ico ok text hidden" id="order-update">Сохранить порядок</a>
	<a href="/admin/block/add" class="ico add text">Новый блок</a>
</div>
<h1>Информационные блоки</h1>
<table class="table" id="table-block">
	<thead>
    	<tr>
        	<th>Наименование</th>
        	<th>Заголовок</th>
        	<th>Класс (CSS)</th>
        	<th>Модель</th>
	        <th>Управление</th>
    	</tr>
    </thead>
    <tbody id="order-list">
    	<?php $group = NULL ?>
    	<?php foreach (Block::get() as $index => $block) : ?>
    		<?php if ($block->group != $group) : ?>
    			<tr class="group<?php if ( ! $index) echo ' order-exclude' ?>" id="_<?php echo $group = $block->group ?>">
    				<td colspan="4"><em>Позиция: <b><?php echo $group ?></b></em></td>
    				<td class="actions">
						<a href="/admin/block/add/<?php echo $group ?>" class="ico add text">Новый блок</a>
    				</td>
    			</tr>
    		<?php endif ?>
    		<tr<?php if ($block->hide) echo ' class="hide"' ?> id="<?php echo $block->id ?>">
    			<td><b class="order-handle"></b><?php echo $block->name ?></td>
    			<td><?php echo $block->title ?></td>
    			<td><?php echo $block->class ?></td>
    			<td><?php echo $block->model_title() ?></td>
    			<td class="actions">
					<a href="<?php echo $block->url_admin('edit') ?>" class="ico edit" title="Редактировать"></a>
					<a href="<?php echo $block->url_admin('toggle') ?>" class="ico hide" title="Видимость"></a>
					<a href="<?php echo $block->url_admin('delete') ?>" class="ico del" title="Удалить"></a>
    			</td>
    		</tr>
    	<?php endforeach ?>
	</tbody>
</table>
<script src="/media/libs/sortable/jquery-ui-1.8.18.custom.min.js"></script>
<script>
it.lang.toggle = ['Блок скрыт', 'Блок влючен'];
it.lang.deleteConfirm = 'Подтвердите удаление блока';
it.lang.deleteOk = 'Блок удален';
it.lang.orderUpdate = 'Порядок блоков сохранен';
</script>