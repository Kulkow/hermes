<div class="right">
	<a href="/admin/module/update<?php echo URL::query() ?>" class="ico upd text">Обновить</a>
</div>
<h1>Управление модулями</h1>
<table class="table" id="table-module">
	<thead>
    	<tr>
        	<th>Наименование</th>
        	<th>Описание</th>
        	<th>Зависимости</th>
        	<th>Блоки</th>
        	<th>Управление</th>
    	</tr>
    </thead>
    <tbody id="order-list">
    	<?php foreach (Module::get() as $module) : ?>
    		<tr<?php if (!(string)$module->active) echo ' class="hide"' ?> id="module-<?php echo $module->name ?>">
    			<td><b class="order-handle"></b><?php echo $module->title ?></td>
    			<td><?php echo $module->description ?></td>
    			<td>
    				<?php if ((string)$module->requires->modules) : ?>
    				<?php else : ?>
    					нет
    				<?php endif ?>
    			</td>
    			<td>
    				<?php foreach ($module->blocks->block as $block) : ?>
    					<?php echo $block->title ?> <small>(<?php echo $block->description ?>)</small><br />
    				<?php endforeach ?>
    			</td>
    			<td class="actions">
    				<?php if ((string)$module->active) : ?>
    					<a href="/admin/module/toggle/<?php echo $module->name ?>" class="ico del text">Деактивировать</a>
    				<?php else : ?>
    					<a href="/admin/module/toggle/<?php echo $module->name ?>" class="ico add text">Активировать</a>
    				<?php endif ?>
    			</td>
    		</tr>

    	<?php endforeach ?>
	</tbody>
</table>
<script src="/media/libs/sortable/jquery-ui-1.8.18.custom.min.js"></script>
<script>
it.lang.toggle = ['Модуль деактивирован', 'Модуль активирован'];
$(function() {
	$('a.ico.add, a.ico.del').unbind('click');
});
</script>