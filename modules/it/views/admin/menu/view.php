<div class="right">
	<a href="/admin/menu/order" class="ico ok text hidden" id="order-update">Сохранить порядок</a>
	<a href="/admin/menu/add" class="ico add text">Новый пункт меню</a>
</div>
<h1>Меню</h1>
<table class="table" id="table-menu">
	<thead>
    	<tr>
        	<th>Заголовок</th>
        	<th>URL</th>
        	<th>Класс (CSS)</th>
	        <th>Управление</th>
    	</tr>
    </thead>
    <tbody id="order-list">
    	<?php $group = NULL ?>
    	<?php foreach (Menu::get() as $index => $item) : ?>
    		<?php if ($item->group != $group) : ?>
    			<tr class="group<?php if ( ! $index) echo ' order-exclude' ?>" id="_<?php echo $group = $item->group ?>">
    				<td colspan="3"><em>Группа: <b><?php echo $group = $item->group ?></b></em></td>
    				<td class="actions">
						<a href="/admin/menu/add/<?php echo $group ?>" class="ico add text">Новый пункт</a>
    				</td>
    			</tr>
    		<?php endif ?>
    		<tr<?php if ($item->hide) echo ' class="hide"' ?> id="<?php echo $item->id ?>">
    			<td><b class="order-handle"></b><?php echo $item->title ?></td>
    			<td><?php echo $item->url ?></td>
    			<td><?php echo $item->class ?></td>
    			<td class="actions">
					<a href="<?php echo $item->url_admin('edit') ?>" class="ico edit" title="Редактировать"></a>
					<a href="<?php echo $item->url_admin('toggle') ?>" class="ico hide" title="Видимость"></a>
					<a href="<?php echo $item->url_admin('delete') ?>" class="ico del" title="Удалить"></a>
    			</td>
    		</tr>
    	<?php endforeach ?>
	</tbody>
</table>
<script src="/media/libs/sortable/jquery-ui-1.8.18.custom.min.js"></script>
<script>
it.lang.toggle = ['Пункт меню скрыт', 'Пункт меню влючен'];
it.lang.deleteConfirm = 'Подтвердите удаление пункта меню';
it.lang.deleteOk = 'Пункт меню удален';
it.lang.orderUpdate = 'Порядок пунктов меню сохранен';
</script>