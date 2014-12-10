<h1>Баннеры</h1>
   <div class="sort">
        <?php $sort_field = array() ?> 
        <?php foreach($sort_field as $field) : ?>
            <div class="field">
              <a href="<?php echo $field->url() ?>" title=""></a>  <?php echo $field['name'] ?>
            </div>
        <?php endforeach ?>
   </div>
   <div class="right">
    	<a href="/admin/banner/add" class="ico add text">Добавить баннер</a>
    </div>
<?php if ($banners) : ?>
   <table class="table">
        <thead>
            <tr>
                <th>Заголовок</th>
                <th>Картинка</th>
                <th>Ссылка</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        	<?php foreach ($banners as $banner) : ?>
        		<tr class="item">
        		        <td><?php echo $banner->title ?></td>
                        <td><?php echo $banner->image ?></td>
                        <td><a href="<?php echo $banner->url() ?>" title="<?php echo $banner->title ?>"><?php echo $banner->url() ?></a></td>
                        <td class="actions">
        					<a href="<?php echo $banner->url_admin('edit') ?>" class="ico edit" title="Редактировать"></a>
        					<a href="<?php echo $banner->url_admin('delete') ?>" class="ico del" title="Удалить"></a>
                        </td>	
        		</tr>
        	<?php endforeach ?>
        </tbody>
    </table>
	<?php echo $paging ?>
<?php endif ?>