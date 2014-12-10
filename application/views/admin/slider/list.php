<h1>Слайдер</h1>
   <div class="sort">
        <?php $sort_field = array() ?> 
        <?php foreach($sort_field as $field) : ?>
            <div class="field">
              <a href="<?php echo $field->url() ?>" title=""></a>  <?php echo $field['name'] ?>
            </div>
        <?php endforeach ?>
   </div>
   <div class="right">
    	<a href="/admin/slider/add" class="ico add text">Добавить баннер</a>
    </div>
<?php if ($sliders) : ?>
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
        	<?php foreach ($sliders as $slider) : ?>
        		<tr class="item">
        		        <td><?php echo $slider->title ?></td>
                        <td><?php echo $slider->image ?></td>
                        <td><a href="<?php echo $slider->url() ?>" title="<?php echo $slider->title ?>"><?php echo $slider->url() ?></a></td>
                        <td class="actions">
        					<a href="<?php echo $slider->url_admin('edit') ?>" class="ico edit" title="Редактировать"></a>
        					<a href="<?php echo $slider->url_admin('delete') ?>" class="ico del" title="Удалить"></a>
                        </td>	
        		</tr>
        	<?php endforeach ?>
        </tbody>
    </table>
	<?php echo $paging ?>
<?php endif ?>