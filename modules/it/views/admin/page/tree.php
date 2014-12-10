<div class="right">
	<a href="/admin/page/order" class="ico ok text hidden" id="order-update">Сохранить</a>
	<a href="/admin/page/add" class="ico add text">Создать страницу</a>
</div>
<h1>Страницы</h1>
<table class="table" id="pages">
	<thead>
    	<tr>
        	<th>Название</th>
        	<th>Псевдоним</th>
	        <th>Управление</th>
    	</tr>
    </thead>
    <tbody>
	    <?php foreach ($tree as $page): ?>
		    <tr<?php if ($page->hide) echo ' class="hide"' ?> id="<?php echo $page->id ?>">
		        <td><b class="sortable-handle"></b>
			    	<?php if ($offset = ($page->level - 1) * 20) : ?>
			        	<div style="padding-left:<?php echo $offset ?>px"><?php echo $page->title ?></div>
			        </td>
					<td>
						<div style="padding-left:<?php echo $offset ?>px">/<?php echo $page->alias ?></div>
					<?php else : ?>
						<?php echo $page->title ?>
					</td>
					<td>
						/<?php echo $page->alias ?>
					<?php endif ?>
				</td>
				<td class="actions">
					<a href="<?php echo $page->url_admin('add') ?>" class="ico add" title="Создать дочернюю страницу"></a>
					<a href="<?php echo $page->url_admin('edit') ?>" class="ico edit" title="Редактировать"></a>
					<a href="<?php echo $page->url_admin('toggle') ?>" class="ico hide" title="Видимость"></a>
					<a href="<?php echo $page->url_admin('delete') ?>" class="ico del" title="Удалить"></a>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
<script>
it.lang.toggle = ['Категория скрыта', 'Категория влючена'];
it.lang.deleteConfirm = 'Подтвердите удаление категории';
it.lang.deleteOk = 'Категория удалена';
it.lang.orderUpdate = 'Порядок категорий сохранен';
</script>